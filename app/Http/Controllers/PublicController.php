<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Setting;

use Auth;
use Validator;
use ClientSafeApi;

class PublicController extends Controller
{
    public function testLoginUser(){
        $user = User::where('email', 'user@test.com')->firstOrFail();
        auth()->login($user, true);
        return redirect()->route('homepage');      
    }  

    public function testLoginAdmin(){
        $user = User::where('email', 'admin@test.com')->firstOrFail();
        auth()->login($user, true);
        return redirect()->route('admin_dashboard');      
    }

    public function displayHomepage()
    {        
        $page_heading = 'Coupon, Promo Codes & Daily Deals';
        $meta_title = 'Coupon, Promo Codes & Daily Deals | '.config('env_custom.app_name');
        return view('homepage', compact('meta_title', 'page_heading'));
    }

    public function showPin(Request $request)
    {    
        $page_heading = 'SAFE';
        $meta_title = 'Login to your account | '.config('env_custom.app_name');
        if ($request->session()->has('aid_transaction')) {
            $tx = $request->session()->get('aid_transaction');
            $pin = $tx->securityCode;
            $status = $tx->status;
            $anchorid = $request->session()->get('anchorid');           
        }
        
        if(isset($status) && $status == 'PROCESS'){ //all good, show pin:           
            return view('showpin', compact('meta_title', 'page_heading', 'pin', 'anchorid'));
        } else {
            return redirect()->route('homepage')->with('error', 'Unable to init signin.'); 
        }       
    }

    //incoming from API
    public function preregistered(Request $request)
    {
        $request->validate([
            'safe_id' => 'required',
            'phone' => 'required',
        ]);
        $safe_id = $request->query('safe_id');
        $phone = $request->query('phone');

        //remove '<'
        if (substr($safe_id, 0, 1) == '<'){
            $safe_id = str_replace('<','',$safe_id);
        }
        //add '<'
        $aid = substr($safe_id, 0, 1) != '<' ? '<'.$safe_id : $safe_id;

        // check if they're an existing user
        $existingUser = User::where('anchor_id', '=', $safe_id)->first();
        if($existingUser) {     
            return response()->json(['status' => false, 'message' => 'User already exists'], 422);
        }        

        // now let's check if given SAFE_ID exists and is linked to this app        
        $client_api = new ClientSafeApi;
        $check = $client_api->call('prompt', [
            'client_application_user_aid' => $aid,
            'client_application_user_phone' => $phone,
        ]);
        $r = json_decode($check['json_body']);
        if(isset($check['error']) && $check['error'] == true){
            return response()->json([
                'status' => false,
                'message' => $r->description ?? null,
            ], 422);
        }

        $access_token = $client_api->getAccessToken($aid);        
        if(!$access_token){
            return response()->json([
                'status' => false,
                'message' => 'no access token',
            ], 422);
        }
        
        //Get user profile details
        $details = $client_api->call('consumer', ['aid' => $aid, 'access_token' => $access_token]);
        $r = json_decode($details['json_body']);        

        if(isset($details['error']) && $details['error'] == true){
            return response()->json([
                'status' => false,
                'message' => $r->description ?? null,
            ], 422);
        } 

        if(isset($r->description->consumer)){
            $profile = $r->description->consumer;
        }

        // at this point we know that this is a new client for our app
        // no user has been associated between this safe_id and our app
        // now we need to tell SAFE to add our user to their system

        //create new user internally
        try {
            $newUser = new User;
            $newUser->password = bcrypt('testing');
            $newUser->name = $profile->name ?? null;
            $newUser->email = $profile->email ?? null;
            $newUser->mobile = $profile->phone ?? null;
            $newUser->user = 1;
            $newUser->anchor_id = $safe_id;
            $newUser->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?? null,
            ], 422);
        }        

        //DO PROMPT linking now, assign newly created internal user_id with Safe ($newUser->id  => $aid)

        $prompt = $client_api->call('prompt', [
            'client_application_user_id' => $newUser->id,
            'client_application_user_aid' => $aid,
            'client_application_user_phone' => $newUser->mobile,
        ]);
        $r = json_decode($details['json_body']);

        if(isset($prompt['error']) && $prompt['error'] == true){
            return response()->json([
                'status' => false,
                'message' => $r->description ?? null,
            ], 422);
        }

        return response()->json(['status' => true], 201);
    }

    public function preregisteredWeb(Request $request)
    {    
        $page_heading = 'SAFE';
        $meta_title = 'Preregistered | '.env('APP_NAME');
        $request->validate([
            'safe_id' => 'required',
            'phone' => 'required',
            ]);
        $safe_id = $request->query('safe_id');
        $phone = $request->query('phone');
        //remove '<'
        if (substr($safe_id, 0, 1) == '<'){
            $safe_id = str_replace('<','',$safe_id);
        }        
        //add '<'
        $aid = '<'.$safe_id;
        
        $error_type = null;        
        
        // check if they're an existing user
        $existingUser = User::where('anchor_id', '=', $safe_id)->first();
        
        if($existingUser) {     
            $error_type = 1;              
            return view('preregistered_fail', compact('meta_title', 'page_heading', 'safe_id', 'error_type'));           
        }
        
        // now let's check if given SAFE_ID exists and is linked to this app        
        $client_api = new ClientSafeApi;
        $check = $client_api->call('prompt', [
            'client_application_user_aid' => $aid,
            'client_application_user_phone' => $phone,
        ]);
        $r = json_decode($check['json_body']);      

        if(isset($check['error']) && $check['error'] == true){           
            return view('preregistered_fail', compact('meta_title', 'page_heading', 'safe_id', 'error_type', $r->description));
        }

        $access_token = $client_api->getAccessToken($aid);
        if(!$access_token){
            $e = 'access token error';
            return view('preregistered_fail', compact('meta_title', 'page_heading', 'safe_id', 'error_type', 'e'));
        }

        //Get user profile details
        $details = $client_api->call('consumer', ['aid' => $aid, 'access_token' => $access_token]);
        $r = json_decode($details['json_body']);

        if(isset($details['error']) && $details['error'] == true){             
            $e = "Error: ".$r->error;
            $e .= '('.$r->error_description.')';
            $error_type = 6;
            return view('preregistered_fail', compact('meta_title', 'page_heading', 'safe_id', 'error_type', 'e'));
        }

        if(isset($r->description->consumer)){
            $profile = $r->description->consumer;
        } 

        // at this point we know that this is a new client for our app
        // no user has been associated between this safe_id and our app
        // now we need to tell SAFE to add our user_id to their system

        try {
            $newUser = new User;
            $newUser->password = bcrypt('testing');
            $newUser->name = $profile->name ?? null;
            $newUser->email = $profile->email ?? null;
            $newUser->mobile = $profile->phone ?? null;
            $newUser->user = 1;
            $newUser->anchor_id = $safe_id;
            $newUser->save();
            auth()->login($newUser, true);  
        } catch (\Illuminate\Database\QueryException $e) {
            $error_desc = $e->getMessage();
            $db_error = true;
        }
        
        if(isset($db_error) && $db_error == true){
            $e = "Internal Error: ";
            $e .= '('.$error_desc.')';
            $error_type = 7;
            return view('preregistered_fail', compact('meta_title', 'page_heading', 'safe_id', 'error_type', 'e'));
        }

        //DO PROMPT linking now, assign newly created internal user_id with Safe ($newUser->id  => $aid)       
        $prompt = $client_api->call('prompt', [
            'client_application_user_id' => $newUser->id,
            'client_application_user_aid' => $aid,
            'client_application_user_phone' => $newUser->mobile,
        ]);
        $r = json_decode($details['json_body']);

        if(isset($prompt['error']) && $prompt['error'] == true){
            //         
            $e = "Error: ".$r->error;
            $e .= '('.$r->error_description.')';
            $error_type = 8;
            return view('preregistered_fail', compact('meta_title', 'page_heading', 'safe_id', 'error_type', 'e'));
        }

        return view('preregistered_success', compact('meta_title', 'page_heading', 'safe_id', 'data_out'));
         
    }

    public function unregister(Request $request)
    {   
        //validator start
        $input = $request->all();
        $rules = [
            'safe_id' => 'required',
            'token' => 'required',
        ];
        $messages = [
            'safe_id.required' => 'safe_id is required to continue',
            'token.required' => 'token is required to continue',
        ];
        $validator = Validator::make($input, $rules, $messages);        

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        //validator end

        $safe_id = $request->input('safe_id');
        $token = $request->input('token');

        $client_api = new ClientSafeApi;
        $settings = $client_api->getSettings('safe');
        $client_id = $settings->client_id;
        $client_secret = $settings->client_secret;

        if (base64_decode($token) != $client_id.':'.$client_secret){
            return response()->json(['error' => 'unauthorized'], 401);
        }

         //remove '<'
        if (substr($safe_id, 0, 1) == '<'){
            $safe_id = str_replace('<','',$safe_id);
        }

        //add '<'
        $aid = substr($safe_id, 0, 1) != '<' ? '<'.$safe_id : $safe_id;
        $existingUser = User::where('anchor_id', '=', $safe_id)->first();
        if(!$existingUser) {
            return response()->json(['error' => 'user not found'], 409);
        }

        $existingUser->delete();  
        return response()->json([
            'safe_id' => $aid,
            'client_id' => $client_id,
        ]);
    }
   
    private function checkID($uid)
    {
        return "user id is: {$uid}";
    }

    public function returnUserID($uid)
    {
        return $this->checkID($uid);
    }
        
    public function twLogin()
    {
        return redirect()->route('homepage')->with('error', 'This route is not implemented at the moment'); 
    }

    public function scLogin()
    {
        return redirect()->back()->with('error', 'This route is not implemented at the moment'); 
    }

    public function fbLogin()
    {
        return redirect()->back()->with('error', 'This route is not implemented at the moment'); 
    }
};