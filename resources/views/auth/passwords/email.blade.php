@extends('layouts.master')

@section('main-content')

<div class="uk-section uk-section-muted" uk-height-viewport="expand: true">
    <div class="uk-container uk-flex uk-flex-center uk-flex-middle">
        <div class="uk-card uk-card-default uk-box-shadow-xlarge">
            <form method="POST" action="{{ route('password.email') }}">
            @csrf
                <div class="uk-card-header uk-text-center">
                    <h3 class="uk-card-title">{{ __('Reset Password') }}</h3>
                </div>

                <div class="uk-card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="uk-margin">                          
                        <label class="uk-form-label" for="email">{{ __('E-Mail Address') }}</label>
                        <div class="uk-form-controls">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="uk-input {{ $errors->has('email') ? ' uk-form-danger' : '' }}" required>                                
                            @if ($errors->has('email'))
                                <div class="uk-alert-danger" uk-alert>
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif    
                        </div>                            
                    </div>                                      
                </div>

                <div class="uk-card-footer">
                    <div class="uk-margin">
                        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">{{ __('Send Password Reset Link') }}</button>
                    </div>                           
                </div>            
            </form>
        </div>
    </div>
</div>
@endsection
