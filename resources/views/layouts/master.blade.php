<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('assets/img/safe/safe.png')}}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/img/safe/safe.png')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('env_custom.app_name'))</title>
        <link rel="stylesheet" href="{{ asset('assets/css/uikit.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}" />
    </head>
    <body>
        <div class="page">

            @include('includes.navigation')
            @yield('main-content')
            @include('includes.footer')
            
        </div>
        <script src="{{ asset('assets/js/app.js')}}"></script>
        <script src="{{ asset('assets/js/uikit-compiled/uikit-icons.min.js')}}"></script>
    </body>
</html>