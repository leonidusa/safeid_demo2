<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Validator;
use ClientSafeApi;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    protected function redirectTo()
    {
        $user = Auth::user();
        if ($user->admin == true){
            return route('admin_dashboard');
        } else {
            return route('homepage'); 
            // return redirect()->route('userProfile')->with('success', 'Welcome back, '.$user->name.'!'); 
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = route('userProfile');
    }


    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */

    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToProviderGoogleSignup(Request $request)
    {
        $request->session()->put('signup', true);
        return Socialite::driver('google')->redirect();    
    }
 
     /**
      * Obtain the user information from GitHub.
      *
      * @return \Illuminate\Http\Response
      */

    public function handleProviderCallbackGoogle(Request $request)
    {
        $signup = $request->session()->get('signup', false);
        $user = Socialite::driver('google')->user();

        // check if they're an existing user
        $existingUser = User::where('email', '=', $user->email)->orWhere('google_id', '=', $user->id)->first();
        if($existingUser) {
            //update user profile to db:
            $existingUser->google_id = $user->id;
            $existingUser->name = $user->name; //optionally reset name from google
            $existingUser->save();

            // log user in
            auth()->login($existingUser, true);

            //check user role:
            if($existingUser->admin){
                return redirect()->route('admin_dashboard')->with('success', 'Welcome back, '.$existingUser->name.'!'); 
            }
        } else {

            if($signup){
                // create a new user
                $newUser = new User;
                $newUser->password = bcrypt('testing');
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->google_id = $user->id;
                $newUser->user = 1;
                $newUser->save();
                auth()->login($newUser, true);

            } else {
                //send them back to homepage if user email not found
                return redirect()->route('homepage')->with('error', 'User not found'); 
            }        
        }     
        return redirect()->route('userProfile')->with('success', 'Welcome back, '.$user->name.'!'); 
    }

    public function initAnchor(Request $request)
    {
        //validator start
        $input = $request->all();
        $rules = [
            'aid' => 'required',
        ];
        $messages = [
            'aid.required' => 'Missing AnchorID',
        ];
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //validator end
        $safe_id = $request->input('aid');

        //remove '<'
        if (substr($safe_id, 0, 1) == '<'){
            $safe_id = str_replace('<','',$safe_id);
        }

        //add '<'
        $aid = substr($safe_id, 0, 1) != '<' ? '<'.$safe_id : $safe_id;

        // check if they're an existing user
        $existingUser = User::where('anchor_id', '=', $safe_id)->first();
        if(!$existingUser) {            
            return redirect()->back()->with('error', $safe_id.' not found within this site users.');             
        }
        
        $request->session()->put('anchorid', $safe_id);

        //get_auth_code:         
        $client_api = new ClientSafeApi;
        $access_token = $client_api->getAccessToken($aid);
        if(!$access_token){
            return redirect()->back()->with('error', 'Unable to get access token.');
        }
        $request->session()->put('aid_access_token', $access_token);

        //Sign In Initiation:
        $init_signin = $client_api->call('init_signin', ['aid' => $aid, 'access_token' => $access_token]);
        $r = json_decode($init_signin['json_body']);

        if (isset($r->description->transaction)){
            $request->session()->put('aid_transaction', $r->description->transaction);
            return redirect()->route('show_pin');
        } else {
            switch ($r->status) {
                case 1335:
                    $e = "Transaction is in process. Please give it upto 1 minute and then try to login again";
                    break;
                default:
                    $e = $r->description;
            }
            return redirect()->back()->with('error', $e.' (step 3)');           
        }
    }
    
    public function SignInStatusCheck(Request $request)
    {
        $input = $request->all();
        $rules = [
            'aid' => 'required',
        ];
        $messages = [
            'aid.required' => 'Missing AnchorID',
        ];

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error'=>'missing safe id']);
        }
        
        $safe_id = $aid = $request->input('aid');
        
        //remove '<'
        if (substr($safe_id, 0, 1) == '<'){
            $safe_id = str_replace('<','',$safe_id);
        }

        //add '<'
        $aid = substr($safe_id, 0, 1) != '<' ? '<'.$safe_id : $safe_id;
        
        if ($request->session()->has('aid_transaction')) {
            $tx = $request->session()->get('aid_transaction', null);
            $transactionId = $tx->transactionId;
        }
        $access_token = $request->session()->get('aid_access_token');
        
        $response = array(
            'success' => true,
            'aid' => $aid,
            'id' => $transactionId,
        );
        
        $client_api = new ClientSafeApi;
        $signin = $client_api->call('signin_status_check', ['transactionId' => $transactionId, 'access_token' => $access_token]);
        $r = json_decode($signin['json_body']);

        if($signin['error'] === false){           
            $status = $r->description->transaction->status; //could be PROCESS, AUTHORIZED, TIMED_OUT, DECLINED, ABORTED
            switch($status){
                case 'PROCESS':
                $response['status'] = 'PROCESS';
                break;
    
                case 'TIMED_OUT':
                break;
    
                case 'DECLINED':
                break;
    
                case 'ABORTED':
                break;
    
                case 'AUTHORIZED':
                $response['status'] = 'AUTHORIZED';
                $response['clientAppId'] = $r->description->transaction->clientAppId;          
                $response['redirect'] = $r->description->client_app->redirectUrl;          
    
                // check if they're an existing user and log user in if exist
                $existingUser = User::where('anchor_id', '=', $safe_id)->first();
                if($existingUser) {               
                    $logged_in = auth()->login($existingUser, true);
                    $response['logged_in'] = $logged_in;
                }
                break;
            }           
        } else {
            $response['success'] = false;
            $response['error_msg'] = $r->description;
            $status = $r->status;
        }

        return response()->json($response);
    }
}
