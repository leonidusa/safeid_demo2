<?php

$app_mode = env('APP_ENV');

$vars = array(
    'app_name' => 'Thesafebutton.com demo site',
    'app_url' => 'https://thesafebutton.com', 
);


switch ($app_mode) {
    case "production":
        $env_vars = array(
            'api' => env('SAFE_API'),
            'oauth' => env('SAFE_OAUTH'),
            'client_id' => env('SAFE_CLIENT_ID'),
            'client_secret' => env('SAFE_CLIENT_SECRET'),
            'client_safe_id' => env('SAFE_CLIENT_SAFE_ID'),
        );
        break;
    default:
        $env_vars = array(
            'api' => env('SAFE_API'),
            'oauth' => env('SAFE_OAUTH'),
            'client_id' => env('SAFE_CLIENT_ID'),
            'client_secret' => env('SAFE_CLIENT_SECRET'),
            'client_safe_id' => env('SAFE_CLIENT_SAFE_ID'),
        );     
}

return array_merge($vars, $env_vars);

// config('env_custom.some_var')

// Optimizing Configuration Loading
// php artisan config:cache


// Optimizing Route Loading
// If you are building a large application with many routes, you should make sure that you are running the route:cache Artisan command during your deployment process:

// php artisan route:cache


// If you execute the config:cache command during your deployment process, you should be sure that you are only calling the env function from within your configuration files. Once the configuration has been cached, the .env file will not be loaded and all calls to the env function will return null.