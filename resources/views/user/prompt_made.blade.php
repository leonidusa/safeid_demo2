@extends('layouts.master')

@section('title')
{{$meta_title}}
@endsection

@section('main-content')
<div class="uk-section uk-section-xsmall">
    <div class="uk-container">
        @include('shared.errors-uikit')
        @include('shared.notify-uikit')
        <div class="uk-h3">{{$page_heading}},</div>        
    </div>
</div>

<div class="uk-section uk-section-muted uk-section-xsmall" uk-height-viewport="expand: true">
    <div class="uk-container">                    
        <div class="uk-margin">
            <div class="uk-tile uk-tile-default uk-text-center uk-tile-small">
                <h2 class="uk-modal-title">Please check your mobile device now.</h2>
                <p>We have sent you unique link via SMS to <b>{{$user->mobile}}</b></p>
                <p>Once you get it, click on it and follow installation instructions.</p>
                <p><img src="{{asset('assets/img/safe/vectorized_button.png')}}" style="max-width: 300px;"></p>
            
                <div class="uk-margin">
                    <p><b>When you finish with 'SAFE' app installations, click the button below to complete integration</b></p>
                    <p><button id="js-connect" class="uk-button uk-button-secondary">Connect my profile with SAFE</button></p>
                    <span id="js-notification" class="uk-label"></span>
                </div> 
            </div>             
        </div>
    </div>
</div>

@endsection