@extends('layouts.master')

@section('main-content')

<div class="uk-section uk-section-muted" uk-height-viewport="expand: true">
    <div class="uk-container uk-flex uk-flex-center uk-flex-middle">
            <div class="uk-card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="uk-margin">                          
                            <label class="uk-form-label" for="email">{{ __('E-Mail Address') }}</label>
                            <div class="uk-form-controls">
                                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" class="uk-input {{ $errors->has('email') ? ' uk-form-danger' : '' }}" required autofocus>                                
                                @if ($errors->has('email'))
                                    <div class="uk-alert-danger" uk-alert>
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif    
                            </div>                            
                        </div>

                        <div class="uk-margin">                        
                            <label class="uk-form-label" for="password">{{ __('Password') }}</label>
                            <div class="uk-form-controls">
                                <input type="password" id="password" name="password" class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" required>                            
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
                                <input type="password" id="password-confirm" name="password_confirmation" class="uk-input" required> 
                            </div>                            
                        </div>

                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-primary uk-width-1-1">{{ __('Reset Password') }}</button>
                        </div> 

                    </form>
                </div>
            </div>
    </div>
</div>
@endsection
