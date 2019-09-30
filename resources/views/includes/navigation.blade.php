
{{-- mobile navbar --}}
<div class="tm-header-mobile uk-hidden@m">

    <nav class="uk-navbar-container" uk-navbar>
        
            <div class="uk-navbar-left">
                <a href="/" class="uk-navbar-item uk-logo">
                    Coupons
                </a>
            </div>

            @if(!Auth::check()) 
            <div class="uk-navbar-center">
                <div class="uk-tile uk-tile-primary" style="padding-top: 5px;padding-bottom: 5px;">                    
                    <a href="#modal-login" uk-toggle class="uk-flex uk-flex-column uk-flex-middle uk-link-reset">
                        <span uk-icon="icon: user"></span>
                        <span>login</span>
                    </a>
                </div>           
            </div>
            @endif
    
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
            <ul class="uk-nav uk-nav-primary">
                <li class="uk-nav-header">Account</li>
                <li class="uk-nav-divider"></li>
                @if(Auth::check()) 
                @if (!Auth::user()->anchor_id && Auth::user()->prompt_made)
                <li><a href="{{ route('userReconnectSafe') }}"><span uk-icon="icon: link"></span> connect SAFE</a></li>               
                @endif
                <li><a href="{{ route('userProfile') }}"><span uk-icon="icon: cog"></span> profile</a></li>
                <li><a href="{{ route('logout') }}"><span uk-icon="icon: sign-out"></span> logout</a></li>
               
                @else
                <li><a href="#modal-login" uk-toggle><span uk-icon="icon: user"></span></span> login</a></li>
                <li><a href="{{ route('register') }}"><span uk-icon="icon: lock"></span></span> register</a></li>
                @endif
            </ul>            
        </div>
    </div>
</div>           

{{-- desktop navbar --}}
<div class="tm-header uk-visible@m" uk-header>
    <div uk-sticky media="@m" cls-active="uk-navbar-sticky" sel-target=".uk-navbar-container" class="uk-sticky uk-sticky-fixed">
        <div class="uk-navbar-container">
            <div class="uk-container">                
                <nav class="uk-navbar-container uk-navbar" uk-navbar='{"align":"center","boundary":"!.uk-navbar-container","dropbar-mode":"slide"}'>                    
                    <div class="uk-navbar-left">
                        <a href="/" class="uk-navbar-item uk-logo">
                            Coupons
                        </a>                       
                    </div>
                    <div class="uk-navbar-right">
                    @if(Auth::check()) 

                   
                        @if (!Auth::user()->anchor_id && Auth::user()->prompt_made)
                        <div class="uk-margin-right">
                            <a href="{{ route('userReconnectSafe') }}" class="uk-flex uk-flex-column uk-flex-middle uk-link-reset" title="Connect your profile with SAFE" uk-tooltip>
                                <span uk-icon="icon: link"></span>
                                <span>SAFE</span>
                            </a>
                        </div>
                        @endif


                        <div title="{{ Auth::user()->name }}" uk-tooltip>
                            <a href="{{ route('userProfile') }}" class="uk-button uk-button-default">
                                <span class="uk-margin-small-right" uk-icon="icon: cog"></span>
                                <span>profile</span>
                            </a>                            
                        </div>

                        <div class="uk-margin-left">
                            <a href="{{ route('logout') }}" class="uk-button uk-button-secondary">
                                <span class="uk-margin-small-right" uk-icon="icon: sign-out"></span>
                                <span>logout</span>
                            </a>
                        </div>
                    @else
                        <div>                            
                            <a href="#modal-login" class="uk-button uk-button-primary" uk-toggle>
                                <span class="uk-margin-small-right" uk-icon="icon: sign-in"></span>
                                <span>login</span>
                            </a>
                        </div>
                        <div class="uk-margin-left">
                            <a href="{{ route('register') }}" class="uk-button uk-button-secondary">
                                <span class="uk-margin-small-right" uk-icon="icon: lock"></span>
                                <span>register</span>
                            </a>
                        </div>
                    @endif
                    </div>
                </nav>
            </div>
        </div>             
    </div>
</div>

@include('includes.login_modal')