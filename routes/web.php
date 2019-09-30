<?php

Route::get('/', 'PublicController@displayHomepage')->name('homepage');
// demo routes for fast login
Route::get('login-user', 'PublicController@testLoginUser');
Route::get('login-admin', 'PublicController@testLoginAdmin');

// OAUTH routes
Route::get('/tw-login', 'PublicController@twLogin')->name('tw-login');
Route::get('/sc-login', 'PublicController@scLogin')->name('sc-login');
Route::get('/fb-login', 'PublicController@fbLogin')->name('fb-login');

Route::get('/g-login', 'Auth\LoginController@redirectToProviderGoogle')->name('g-login');
Route::get('/g-signup', 'Auth\LoginController@redirectToProviderGoogleSignup')->name('g-signup');
Route::get('/g-login/callback', 'Auth\LoginController@handleProviderCallbackGoogle');

Route::post('/aid-login', 'Auth\LoginController@initAnchor')->name('aid-login');
Route::get('/pin', 'PublicController@showPin')->name('show_pin');
Route::post('/pin', 'Auth\LoginController@SignInStatusCheck');

//special route for preregistered users from mobile app preregistered?safe_id=<user_safe_id>
Route::get('preregistered-web', 'PublicController@preregisteredWeb')->name('preregistered-web');
Route::get('preregistered', 'PublicController@preregistered')->name('preregistered');

//special route for unregister users from mobile app
Route::post('unregister', 'PublicController@unregister');

//Auth::routes(['register' => false]); //login, logout, register routes
Auth::routes(); //login, logout, register routes

Route::get('/logout', 'UserController@logout')->name('logout');

Route::prefix('user')->group(function(){
    Route::get('profile', 'UserController@profile')->name('userProfile');
    Route::post('profile', 'UserController@profilePost')->name('userProfilePost');
    Route::post('profile/addmobile', 'UserController@addAnchorPost')->name('userAddAnchorPost');
    Route::post('profile/connect', 'UserController@ConnectAnchorPost')->name('userConnectAnchorPost');
    Route::get('profile/reconnect', 'UserController@ReconnectSafe')->name('userReconnectSafe');
    Route::get('profile/restart', 'UserController@ConnectSafeRestart')->name('userConnectSafeRestart');
    Route::post('profile/delete', 'UserController@userDeleteAccount')->name('userDeleteAccount');
});

Route::prefix('admin')->group(function(){    
    Route::get('/', 'AdminController@dashboard')->name('admin_dashboard');    
    Route::get('settings/{service}', 'AdminController@adminSettings')->name('admin_settings_service');
    Route::post('settings/{service}', 'AdminController@adminSettingsPost')->name('admin_settings_save');
    Route::get('users', 'AdminController@users')->name('admin_users');
    Route::get('user/{id}/edit', 'AdminController@editUser')->name('adminEditUser');
    Route::post('user/{id}/edit', 'AdminController@updateUser')->name('adminUpdateUser');
    Route::post('user/{id}/delete', 'AdminController@deleteUser')->name('adminDeleteUser');        
});
