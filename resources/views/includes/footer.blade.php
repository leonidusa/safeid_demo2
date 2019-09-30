{{-- footer --}}
<div class="uk-section uk-section-secondary uk-section-xsmall">
    <div class="uk-container">
        <div class="uk-grid-large uk-grid-margin-large uk-grid" uk-grid>            
            <div class="uk-width-expand@m">
                <div class="uk-text-small">
                    © <?= date('Y'); ?> - <a class="uk-icon-link" target="_blank" href="{{ config('env_custom.app_url') }}">{{ config('env_custom.app_url') }}</a>
                </div>
            </div>

            <div class="uk-width-expand@m">
                <div class="uk-child-width-auto uk-grid-small uk-grid uk-flex-right@m" uk-grid>
                    <div>
                        <a class="uk-icon-link uk-icon" target="_blank" href="https://www.instagram.com" uk-icon="icon: instagram;"></a>
                    </div>
                    <div>
                        <a class="uk-icon-link uk-icon" target="_blank" href="https://facebook.com/" uk-icon="icon: facebook;"></a>
                    </div>
                    <div>
                        <a class="uk-icon-link uk-icon" target="_blank" href="https://twitter.com/" uk-icon="icon: twitter;"></a>
                    </div>
                    <div>
                        <a class="uk-icon-link uk-icon" target="_blank" href="https://youtube.com/" uk-icon="icon: youtube;"></a>
                    </div>  
                </div>
            </div>            
        </div>
    </div>
</div>

{{-- <a href="#" title="" class="js-totop totop">
    <span uk-icon="icon: chevron-up"></span>
    <span uk-icon="icon: chevron-up"></span>
</a> --}}
