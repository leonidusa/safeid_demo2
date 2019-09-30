<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdate;
use Carbon;
use Validator;
use ClientSafeApi;
use App\Setting;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }    

    public function profile()
    {
        $user = Auth::user();
        $meta_title = 'Complete SAFE integration';
        $page_heading = $user->name.' profile. You are now logged in.';        
        return view('user.profile', compact('meta_title', 'page_heading', 'user'));
    }    

    public function profilePost(UserUpdate $request)
    {
        $request->validate([            
            'email' => 'email'
        ]);

        $user = Auth::user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->anchor_id = $request['aid'];
        $user->save();

        
        if ($request->has(['password', 'new_password'])) {
            //check if password provided is the same as saved for the user (use Hash)
            if(!(Hash::check($request['password'], Auth::user()->password))){
                return redirect()->back()->with('error', 'Your current password does not match');
            } 
            
            //compare old and new passwords, make sure they are not the same. binary safe str compare
            if(strcmp($request['password'],$request['new_password']) == 0){
                return redirect()->back()->with('error', 'Your new password can not be the same as current');                
            }

            $validation = $request->validate([
                'password' => 'required',
                'new_password' => 'required|string|min:6|confirmed'
            ]);

            $user->password = bcrypt($request['new_password']);
            $user->save();

            return redirect()->back()->with('success', 'New password saved');   
        }
        return back()->with('success', 'Profile data has been updated');
    }

    public function userDeleteAccount(Request $request)
    {
        if (!$request->has('confirm-delete') && $request->input('confirm-delete') != 'on') {
            return redirect()->back()->with('error', 'delete confirmation failed');
        }   
            
        $user = Auth::user();
        $user_id = $user->id;
        $safe_id = $user->anchor_id;
        
        //add '<' to aid if safe_id exists
        $aid = null;
        if($safe_id){
            $aid = substr($safe_id, 0, 1) != '<' ? '<'.$safe_id : $safe_id;
        }

        $client_api = new ClientSafeApi;
        $access_token = $client_api->getAccessToken($aid);
        if(!$access_token){
            return redirect()->back()->with('error', 'System error: token missing');            
        }

        //send a request to AID to deactivate the user from this app
        $deactivate_user = $client_api->call('deactivate_user', ['aid' => $aid, 'client_user_id' => $user_id, 'active' => 0, 'access_token' => $access_token]);        
        $r = json_decode($deactivate_user['json_body']);
        
        if($deactivate_user['error'] && isset($r)){
            return redirect()->back()->with('error', $r->description ?? 'System error');            
        }

        User::destroy($user_id);
        Auth::logout();

        return redirect()->route('homepage')->with('success', 'Username and data was completely removed. Thank you.');
    }

    public function addAnchorPost(Request $request){
        $user = Auth::user();

        //validator start
        $input = $request->all();
        $rules = [
            'mobile.full' => 'required',
        ];
        $messages = [
            'mobile.full.required' => 'Mobile number is required to continue',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //validator end
        
        $phone = str_replace(array('.', ' ', '-', '(', ')'), '', $request->input('mobile.full'));
        
        //update current user profile first
        $user->mobile = $phone;
        $user->save();
        
        // This call will create an unique signup link and may send SMS containing the link
        $client_api = new ClientSafeApi;
        $prompt = $client_api->call('prompt', [
            'client_application_user_id' => $user->id,
            'client_application_user_phone' => $phone,
            'client_application_user_name' => $user->name,
            'client_application_user_email' => $user->email,
            'send_sms' => true,
        ]);
        
        $r = json_decode($prompt['json_body']);
        
        if(isset($prompt['error']) && $prompt['error'] == true && isset($r)){
            if($r->status == 1976){
                return redirect()->back()->with('error', 'Invalid phone number, make sure to use international formatting.');
            }
            if($r->status == 1507){
                return redirect()->back()->with('error', 'Phone number '.$phone.' mismatch.');
            }
            if($r->status == 1509){
                return redirect()->back()->with('error', 'Phone number '.$phone.' is already registered.');
            }
            return redirect()->back()->with('error', $prompt->description ?? 'System error');            
        }

        $aid = $r->description->client_application_user_aid ?? null;

        //update user profile, add SAFE ID:
        $user = User::find($user->id);
        $success_existing = false;        
        if($aid){
            $success_existing = true;                    
            $user->anchor_id = substr($aid, 0, 1) == '<' ? str_replace('<','',$aid) : $aid;
        }
        $user->prompt_made = 1;
        $user->save();

        if($success_existing){
            return redirect()->route('userProfile')->with('success', 'Success! You may login to our system with SAFE username: '.$user->anchor_id);
        }

        $meta_title = 'Success!';
        $page_heading = $user->name;

        return view('user.prompt_made', compact('meta_title', 'page_heading', 'user'));       

    }

    public function ReconnectSafe()
    {
        $user = Auth::user();
        $meta_title = 'Complete SAFE integration';
        $page_heading = $user->name.' profile. You are logged in.';
        if(empty($user->anchor_id) && $user->prompt_made){            
            return view('user.prompt_made_connect', compact('meta_title', 'user'));           
        }
        
        return view('user.profile', compact('meta_title', 'page_heading', 'user'));
    }

    public function ConnectSafeRestart()
    {
        $user = Auth::user();
        $user->prompt_made = null;
        $user->anchor_id = null;
        $user->save();
        return redirect()->route('userProfile');
    }

    public function ConnectAnchorPost(Request $request)
    {
        $user = Auth::user();
        $response = array();
        $response['uid'] = $user->id;
        $response['success'] = false;
        $response['error_msg'] = 'We can not find your SAFE username. Make sure you have installed the app and finished registration process.';

        $client_api = new ClientSafeApi;        
        $check = $client_api->call('prompt', [
            'client_application_user_id' => $user->id,
            'client_application_user_phone' => $user->mobile,
        ]);
        $r = json_decode($check['json_body']);

        $safe_id = $r->description->client_application_user_aid ?? null;
        if($check['error'] === false && $safe_id){  
            if (substr($safe_id, 0, 1) == '<'){
                $safe_id = str_replace('<','',$safe_id);
            }
            $response['success'] = true;            
            $response['success_msg'] = 'Success! You may login to our system with SAFE username: '.$safe_id;
            $response['redirect'] = route('userProfile');

            //update user profile, add SAFE ID:
            $user = User::find($user->id);            
            $user->anchor_id = $safe_id;
            $user->save();        
        }
        return response()->json($response);
    }    
}
