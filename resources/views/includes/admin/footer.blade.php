{{-- footer --}}
<div class="uk-section uk-section-muted uk-section-xsmall uk-padding-remove-vertical">
    <div class="uk-container">
        <div class="uk-grid-large uk-grid-margin-large uk-grid uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-expand@m uk-width-1-2@s uk-text-small">
                © <?= date('Y'); ?> - <a class="uk-icon-link" target="_blank" href="{{ config('env_custom.app_url') }}">{{ config('env_custom.app_url') }}</a>
            </div>
            <div class="uk-flex-middle uk-width-auto">
                <div class="uk-button uk-button-small" uk-totop uk-scroll></div>
            </div>
        </div>
    </div>
</div>
