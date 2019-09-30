@extends('layouts.master')

@section('title')
{{$meta_title}}
@endsection

@section('main-content')
<div class="uk-section uk-section-xsmall">
    <div class="uk-container">
        @include('shared.errors-uikit')
        @include('shared.notify-uikit')
        <div class="uk-h3">{{$user->name.','}}</div>       
    </div>
</div>
<div class="uk-section uk-section-muted uk-section-xsmall" uk-height-viewport="expand: true">
    <div class="uk-container uk-text-center">        
        <div class="uk-margin">
            <div class="uk-tile uk-tile-default uk-tile-small uk-margin">
                <h2 class="uk-modal-title">In order to proceed you need to connect your profile with SAFE</h2>
                <p><img src="{{asset('assets/img/safe/vectorized_button.png')}}" style="max-width: 300px;"></p>
                <p>You will not be able to login to this site with SAFE username until your profile is linked to SAFE</p>
                <p><button id="js-connect" class="uk-button uk-button-secondary">Connect my profile with SAFE</button></p>
                <p>
                    <a href="{{ route('userConnectSafeRestart') }}" class="uk-button uk-button-text uk-margin-bottom" style="width:auto;">Start all over</a>                   
                </p>
                <p id="js-notification" class="uk-label"></p>
            </div>
        </div>
    </div>
</div>

@endsection