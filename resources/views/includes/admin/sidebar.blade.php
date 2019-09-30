<div class="tm-sidebar-left uk-background-secondary uk-light uk-padding uk-flex uk-flex-between uk-flex-column"  uk-height-viewport="expand: true">
    <ul class="uk-nav uk-nav-default">
        @if(Auth::User()->admin == true)
        <li class="uk-nav-header">Admin navigation</li>
        <li class="uk-nav-divider"></li>
        <li class="{{ Route::currentRouteName() == 'admin_dashboard' ? 'uk-active' : ''}}">
            <a href="{{route('admin_dashboard')}}">
                <i class="icon icon-home"></i> Dashboard
            </a>
        </li>
        <li class="{{ Route::currentRouteName() == 'admin_users' ? 'uk-active' : ''}}">
            <a href="{{route('admin_users')}}">
                <i class="icon icon-user"></i> Users
            </a>
        </li>

        <li class="uk-nav-header">Settings</li>
        <li class="{{ Route::currentRouteName() == 'admin_settings_service' ? 'uk-active' : ''}}">
            <a href="{{route('admin_settings_service', 'safe')}}">
                <i class="icon icon-gear"></i> SAFE API
            </a>
        </li>

        @endif
    </ul>

    <div class="uk-background-contain uk-height-medium" style="background-image: url({{ asset('assets/img/aid/icon.png') }});">        
    </div>

</div>