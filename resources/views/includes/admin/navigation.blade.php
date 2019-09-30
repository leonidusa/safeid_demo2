{{-- mobile navbar --}}
<div class="tm-header-mobile uk-hidden@m">

    <nav class="uk-navbar-container" uk-navbar>
        
            <div class="uk-navbar-left">
                <a href="/" class="uk-navbar-item uk-logo">
                    <img src="{{ asset('assets/img/safe/safe.png')}}" alt="logo" style="max-width: 118px;">
                </a>
            </div>
    
            <div class="uk-navbar-right">
                <a class="uk-navbar-toggle" href="#tm-mobile" uk-toggle>
                    <div uk-navbar-toggle-icon></div>
                </a>
            </div>
        
    </nav>
</div>

<div id="tm-mobile" uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar">

        <button class="uk-offcanvas-close" type="button" uk-close></button>
        <div class="uk-panel">  
            <ul class="uk-nav uk-nav-default">                    
                <li><a href="{{ route('admin_dashboard') }}">Home</a></li>
            </ul>            
        </div>
    </div>
</div>
        

{{-- desktop navbar --}}
<div class="tm-header uk-visible@m" uk-header>
    <div uk-sticky media="@m" cls-active="uk-navbar-sticky" sel-target=".uk-navbar-container" class="uk-sticky uk-sticky-fixed">
        <div class="uk-navbar-container" style="background-color: #f9f9f9;">
            <div class="uk-container">                
                <nav class="uk-navbar" uk-navbar='{"align":"center","boundary":"!.uk-navbar-container","dropbar":true,"dropbar-anchor":"!.uk-navbar-container","dropbar-mode":"slide"}'>
                    <div class="uk-navbar-left">
                        <a href="{{ route('admin_dashboard') }}" class="uk-navbar-item uk-logo">
                            <img src="{{ asset('assets/img/safe/safe.png')}}" alt="logo" style="max-width: 65px;">
                        </a>
                        Demo admin dash
                    </div>
                    <div class="uk-navbar-right">                        
                        <div class="uk-navbar-item">
                            @if(Auth::user()->admin != 1)
                            <a href="{{ route('userProfile') }}" class="uk-button uk-button-primary">
                                <i class="fa fa-user"></i> {{ Auth::user()->name }} Profile
                            </a>
                            @else
                            <a href="{{ route('adminEditUser', Auth::user()->id) }}" class="uk-button uk-button-primary">
                                <i class="fa fa-user"></i> {{ Auth::user()->name }} Profile (admin)
                            </a>                            
                            @endif
                        </div>
                        <div class="uk-navbar-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="uk-button uk-button-danger">
                                    <i class="fa fa-lock"></i> Logout
                                </button>
                            </form>                        
                        </div>                        
                    </div>
                </nav>
            </div>
        </div>        
    </div>
</div>

