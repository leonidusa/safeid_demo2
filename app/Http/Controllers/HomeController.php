<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard or redirect to user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function entrance()
    {        
        if(Auth::user()->admin == true){
            return redirect(route('admin_dashboard'));
        } else {
            return redirect(route('userProfile'));
        }
    }
}