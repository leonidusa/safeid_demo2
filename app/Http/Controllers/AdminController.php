<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Setting;
use App\Http\Requests\UserUpdate;
use Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }
    
    public function dashboard()
    {        
        $users = User::all();
        $page_heading = 'Admin Dashboard';
        $meta_title = 'Admin Dashboard | '.config('env_custom.app_name');        
        return view('admin.dashboard', compact('meta_title', 'page_heading', 'users'));
    }    
    
    public function adminSettings($service)
    {
        $setting = Setting::where('service', '=', $service)->firstOrFail();
        $service = $setting->service;
        $data = json_decode($setting->data);

        $client_id = $data->client_id ?? null;
        $client_secret = $data->client_secret ?? null;
        $client_safe_id = $data->client_safe_id ?? null;
        $uri_oauth2 = $data->uri_oauth2 ?? null;
        $uri_signin = $data->uri_signin ?? null;
        $uri_transaction = $data->uri_transaction ?? null;
        $uri_prompt = $data->uri_prompt ?? null;
        $uri_checkclientaid = $data->uri_checkclientaid ?? null;
        $uri_consumer = $data->uri_consumer ?? null;
        $uri_application = $data->uri_application ?? null;
        
        $page_heading = 'Service settings for API';
        $meta_title = 'Service settings | '.env('APP_NAME');
        return view('admin.settings_api', compact(
            'meta_title',
            'page_heading',
            'service',
            'client_id',
            'client_secret',
            'client_safe_id',
            'uri_oauth2',
            'uri_signin',
            'uri_transaction',
            'uri_prompt',
            'uri_checkclientaid',
            'uri_consumer',
            'uri_application'
        ));
    }
    
    public function adminSettingsPost(Request $request, $service)
    {
        $setting = Setting::where('service', '=', $service)->firstOrFail();  
        $data = array(
            'client_id' => $request->input('client_id'),
            'client_secret' => $request->input('client_secret'),
            'client_safe_id' => $request->input('client_safe_id'),
            'uri_oauth2' => $request->input('uri_oauth2'),
            'uri_signin' => $request->input('uri_signin'),
            'uri_transaction' => $request->input('uri_transaction'),
            'uri_prompt' => $request->input('uri_prompt'),
            'uri_checkclientaid' => $request->input('uri_checkclientaid'),
            'uri_consumer' => $request->input('uri_consumer'),
            'uri_application' => $request->input('uri_application')
        );          

        $setting->data = json_encode($data);
        $setting->save();
        return back()->with('success', 'Settings for: '.$service.' updated successfully');
    }
   
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }   

    public function editUser($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.editUser', compact('user'));
    }

    public function updateUser(UserUpdate $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->anchor_id = $request['anchor_id'];

        $request['user'] == 1 ? $user->user = true : $user->user = false;
        $request['admin'] == 1 ? $user->admin = true : $user->admin = false;
        $user->save();

        if ($request->filled('new_password')){
            
            $request->validate([
                'new_password' => 'sometimes|required|string|min:6|confirmed'
            ]);

            $user->password = bcrypt($request['new_password']);
            $user->save();

            return redirect()->back()->with('success', 'New password for user with id: '.$id.' saved');   
        }

        return back()->with('success', 'User with id: '.$id.' updated successfully');
    }

    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return back()->with('success', 'User with id: '.$id.' removed successfully');
    }

}
