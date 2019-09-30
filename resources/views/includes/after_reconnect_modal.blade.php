
<div id="modal-reconnect-login" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-text-center">
        
            <a class="uk-modal-close-default">&times;</a>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Hi {{ $user->name }},</h2>
                <p class="uk-label-danger">Your profile is not connected with SAFE username yet.</p>                
            </div>
            <div class="uk-modal-body">            
                <div class="uk-grid uk-margin uk-child-width-1-1@m" uk-grid>
                    <div>
                        <p>Login with SAFE will not work otherwise</p>
                        <p class="uk-margin uk-text-center"><img src="{{asset('assets/img/safe/vectorized_button.png')}}" style="max-width: 300px;"></p>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-center"> 
                <div>                  
                    <a href="{{ route('userReconnectSafe') }}" class="uk-button uk-button-secondary uk-margin-bottom">Connect SAFE</a>                    
                </div>
                <div>                  
                    <a href="{{ route('userConnectSafeRestart') }}" class="uk-button uk-button-primary uk-margin-bottom">Start all over</a>                    
                </div>
                <div>                  
                    <a class="uk-margin uk-link-reset uk-modal-close">Skip</a>
                </div>                    
            </div>
        
    </div>
</div>


<script>
    window.addEventListener('load', function () {
         UIkit.modal('#modal-reconnect-login').show();
    });
</script>

