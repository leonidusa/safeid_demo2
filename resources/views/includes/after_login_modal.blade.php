<div id="modal-after-login" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-text-center">
        <form action="{{ route('userAddAnchorPost') }}" method="POST">
        @csrf
            <a class="uk-modal-close-default">&times;</a>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Hi {{ $user->name }},</h2>
                <p>Add your mobile phone number if you want to use your smartphone to log in with no password</p>
                <p class="uk-margin uk-text-center"><img src="{{asset('assets/img/safe/vectorized_button.png')}}" style="max-width: 300px;"></p>
            </div>
            <div class="uk-modal-body">            
                <div class="uk-grid uk-margin uk-child-width-1-1@m" uk-grid>
                    <div>
                        <label class="uk-form-label uk-display-inline-block uk-margin" for="mobile">Your mobile, e.g.: <span class="uk-label">+1 202-333-4444</span></label>
                        <div class="uk-form-controls">
                            <input class="uk-input" type="tel" id="mobile" value="{{$user->mobile}}" name="mobile[original]" placeholder="222 333-4444" required>
                            <input class="uk-hidden" type="hidden" id="mobile-full" name="mobile[full]">
                            <span id="valid-msg" class="hide">✓ Valid</span>
                            <span id="error-msg" class="hide"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-center"> 
                <div>                  
                    <button type="submit" class="uk-button uk-button-secondary uk-margin-bottom" id="submit-btn" disabled>Continue</button>                    
                </div>
                <div>                  
                    <a class="uk-margin uk-link-reset uk-modal-close">Skip</a>
                </div>                    
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="{{asset('assets/css/intl/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/intl/isValidNumber.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/intl/demo-overrides.css')}}">

<script src="{{asset('assets/js/intl/build/intlTelInput.min.js')}}"></script>
<script src="{{asset('assets/js/intl/isValidNumber.js')}}"></script>
<script>
    window.addEventListener('load', function () {
        var phone_modal = UIkit.modal('#modal-after-login');
        phone_modal.show();
    });

    var input = document.querySelector("#mobile"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg"),
        submitBtn = document.querySelector("#submit-btn"),
        mobileFull = document.querySelector("#mobile-full");
        
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    // initialise plugin
    var iti = window.intlTelInput(input, {
        nationalMode: false,
        formatOnDisplay: true,        
        initialCountry: "US",
        autoHideDialCode: false,
        preferredCountries: ["us", "gb", 'ca'],
        separateDialCode: true,
        onlyCountries: ["at", "by", "be", "ba", "bg", "hr", "cz", "dk",
        "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
        "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
        "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "gb", "us", "ca"],
        utilsScript: "{{asset('assets/js/intl/build/utils.js')}}"
    });

    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };    
    
    //can find plugin init event, so using this ugly method
    setTimeout(function(){
        if (iti.isValidNumber()) {
            mobileFull.value = iti.getNumber();
            submitBtn.removeAttribute("disabled");
        }
    }, 1000);

    input.addEventListener('input', function() {        
        reset();
        if (input.value.trim()) {

            iti.setNumber(input.value);
            // iti.setPlaceholderNumberType("FIXED_LINE");

            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
                mobileFull.value = iti.getNumber();
                submitBtn.removeAttribute("disabled");

            } else {
                input.classList.add("error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
                submitBtn.setAttribute("disabled", "");
            }
        }    
    });
</script>
