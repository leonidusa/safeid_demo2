@extends('layouts.master')
@section('title') {{$meta_title}} @endsection

@section('main-content')

<div class="uk-section uk-section-muted" uk-height-viewport="expand: true">
    <div class="uk-container js-pin-wrapper" >
        @include('shared.errors-uikit')
        @include('shared.notify-uikit')
        
        <div class="uk-margin uk-text-center">
            <img src="{{asset('assets/img/safe/symb.png')}}" style="max-width: 100px;">            
        </div>
        <div class="uk-text-center">
            <div class="uk-margin">
                <div class="uk-card uk-card-default uk-card-body uk-margin-auto uk-width-1-4@m">
                    <div class="uk-h2">{{$page_heading}}</div>
                    <div class="uk-h1 uk-hidden">{{$pin}}</div>
                    <p>SAFE Username: <span id="js-aid"><b>{{ $anchorid }}</b></span></p>
                </div>
            </div>        
            <p>Please, use your mobile device to authenticate</p>

        </div>
    </div>
</div>

@include('includes.spinner')
@include('includes.footer_demo_section')

@endsection