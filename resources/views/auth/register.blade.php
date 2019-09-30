@extends('layouts.master')

@section('title') {{ __('Create an account') }} @endsection

@section('main-content')
<div class="uk-section uk-section-muted" uk-height-viewport="offset-bottom: true; offset-top: true">    
    <div class="uk-container uk-flex uk-flex-center uk-flex-middle uk-flex-column">
            @include('shared.errors-uikit')
            @include('shared.notify-uikit')
        
        {{-- <div class="uk-card uk-card-default uk-box-shadow-xlarge uk-width-2-3@m">
            <div class="uk-card-header uk-text-center">
                <h4 class="">I have SAFE App and preregistered myself with EDM</h3>
            </div>
            <div class="uk-card-body">
                <div class="uk-grid uk-child-width-1-1@m uk-text-center" uk-grid uk-scrollspy="target: > div;cls:uk-animation-fade; delay: 50">
                    <div>
                        <a href="#reg-via-safe" uk-toggle>
                            <img src="{{asset('assets/img/safe/vectorized_button_long.png')}}" style="max-width: 300px;">
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="uk-card uk-card-default uk-box-shadow-xlarge uk-width-1-2@m">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="uk-card-header uk-text-center">
                    <h3 class="uk-card-title">{{ __('Register') }} with email</h3>
                </div>
                <div class="uk-card-body">                   

                    <div class="uk-margin">                          
                        <label class="uk-form-label" for="name">{{ __('Name') }}</label>
                        <div class="uk-form-controls">
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="uk-input" placeholder="John Doe"> 
                            @if ($errors->has('name'))
                                <div class="uk-alert-danger" uk-alert>
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif   
                        </div>                            
                    </div>
                    <div class="uk-margin">                          
                        <label class="uk-form-label" for="email">{{ __('E-Mail Address') }}</label>
                        <div class="uk-form-controls">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="uk-input {{ $errors->has('email') ? ' uk-form-danger' : '' }}">                                
                            @if ($errors->has('email'))
                                <div class="uk-alert-danger" uk-alert>
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif    
                        </div>                            
                    </div>

                    <div class="uk-margin">                        
                        <label class="uk-form-label" for="email">{{ __('Password') }}</label>
                        <div class="uk-form-controls">
                            <input type="password" id="password" name="password" class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}">                            
                            @if ($errors->has('password'))
                                <div class="uk-alert-danger" uk-alert>
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif    
                        </div>                            
                    </div>

                    <div class="uk-margin">                        
                        <label class="uk-form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                        <div class="uk-form-controls">
                            <input type="password" id="password-confirm" name="password_confirmation" class="uk-input">  
                        </div>                            
                    </div>
 

                    <div class="uk-margin">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">{{ __('Register') }}</button>
                    </div> 
                    <div class="uk-margin uk-text-center">
                        <a href="{{ route('login') }}" class="uk-button uk-button-link">{{ __('Already have an account?') }}</a>
                        <p class="uk-heading-line uk-text-center"><span>OR</span></p>
                        <div>
                            <a href="{{ route('g-signup') }}">
                                <img src="{{asset('assets/img/buttons/g-login@2x.png')}}">
                            </a>
                        </div>   
                    </div>                   
                </div>

            </form>
           
            
        </div>
    </div>
</div>

@endsection
@include('includes.register_via_safe_modal')