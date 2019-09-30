@extends('layouts.master')
@section('title') {{$meta_title}} @endsection

@section('main-content')

<div class="uk-section uk-section-muted" uk-height-viewport="expand: true">
    <div class="uk-container js-pin-wrapper" >
        @include('shared.errors-uikit')
        @include('shared.notify-uikit')
        
        
        <div class="uk-margin">
            <div class="uk-card uk-card-default uk-margin-auto uk-width-1-2@m">
                <div class="uk-card-header" style="background: #deffed;">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-auto">
                            <img src="{{asset('assets/img/safe/symb.png')}}" style="max-width: 50px;">
                        </div>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">Welcome, {{$data_out['name']}}</h3>
                            <p class="uk-text-meta uk-margin-remove-top">It's good to have you aboard</p>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">   
                    <h4 class="uk-text-center">You may now use SAFE username next time to login.</h4>
                    <p>We have updated your profile with following data received:</p>
                    <dl class="uk-description-list uk-description-list-divider">
                        <dt><b>Name:</b></dt>
                        <dd>{{$data_out['name']}}</dd>

                        <dt><b>Email:</b></dt>
                        <dd>{{$data_out['email']}}</dd>

                        <dt><b>SAFE Username:</b></dt>
                        <dd>{{$safe_id}}</dd>
                    </dl>
                </div>
                <div class="uk-card-footer uk-text-center">
                    <a href="{{route ('userProfile')}}" class="uk-button uk-button-secondary">My Profile</a>
                </div>                   
            </div>
        </div>

    </div>
</div>

@include('includes.footer_demo_section')

@endsection
