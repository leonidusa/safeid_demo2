@if (Session::has('success'))
    <div class="uk-section uk-section-xsmall">
        <div class="uk-container">
            <div class="uk-alert-success uk-margin-remove" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{{ Session::get('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if (Session::has('error'))
    <div class="uk-section uk-section-xsmall">
        <div class="uk-container">
            <div class="uk-alert-danger uk-margin-remove" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{{ Session::get('error') }}</p>
            </div>
        </div>
    </div>    
@endif
