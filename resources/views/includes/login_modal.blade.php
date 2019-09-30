<div id="modal-login" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-width-large">
        <a class="uk-modal-close-default">&times;</a>
        <div class="uk-modal-header uk-text-center">
            <h2 class="uk-modal-title">Log in</h2>
            <p>Use SAFE, Google or email</p>
        </div>
        <div class="uk-modal-body">            
            <ul class="uk-list uk-text-center">
                <li>
                    <div class="uk-inline">
                        <img src="{{asset('assets/img/safe/vectorized_button_long.png')}}" style="max-width: 300px;cursor: pointer;">                        
                        <div uk-drop="mode: click">
                            <div class="uk-card uk-card-body uk-card-default uk-card-small">
                                <form method="POST" action="{{ route('aid-login') }}">
                                @csrf
                                    <div class="uk-grid uk-grid-small uk-flex uk-flex-middle" uk-grid>
                                        <div class="uk-width-expand">
                                            <label class="uk-form-label uk-hidden" for="aid">SAFE</label>
                                            <div class="uk-form-controls uk-inline">
                                                <input type="text" id="aid" name="aid" class="uk-input" placeholder="SAFE username"> 
                                            </div> 
                                        </div>
                                        <div class="uk-width-auto">
                                            <button type="submit" class="uk-button uk-button-text">
                                                Login
                                            </button>
                                        </div>             
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('g-login') }}">
                        <img src="{{asset('assets/img/buttons/g-login@2x.png')}}" style="max-width: 300px;">
                    </a>
                </li>                
            </ul>
            <p class="uk-heading-line uk-text-center"><span>OR</span></p>
            <form method="POST" action="{{ route('login') }}">
            @csrf
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
                    <label class="uk-margin-right" for="login">{{ __('Remember Me') }}</label>
                    <input type="checkbox" id="login" class="uk-checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>                           
                </div>   

                <div class="uk-margin">
                    <button type="submit" class="uk-button uk-button-primary uk-width-1-1">{{ __('Login') }}</button>
                </div> 
            </form>
        </div>
    </div>
</div>


