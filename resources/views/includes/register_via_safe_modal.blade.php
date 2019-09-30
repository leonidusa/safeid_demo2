<div id="reg-via-safe" class="uk-flex-top uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-width-large">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Register</h2>
            <p>We only need your SAFE username to register you in our App</p>
            <p>In order for this to work, you must register account with us inside your mobile app</p>
        </div>
        <div class="uk-modal-body">            
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
                            Register
                        </button>
                    </div>                                                
                </div>
            </form>
        </div>
    </div>
</div>


