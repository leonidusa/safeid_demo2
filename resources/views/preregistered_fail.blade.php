@extends('layouts.master')
@section('title') {{$meta_title}} @endsection

@section('main-content')

<div class="uk-section uk-section-muted" uk-height-viewport="expand: true">
    <div class="uk-container js-pin-wrapper" >
        @include('shared.errors-uikit')
        @include('shared.notify-uikit')
        
        
        <div class="uk-margin">
            <div class="uk-card uk-card-default uk-margin-auto uk-width-1-2@m">
                <div class="uk-card-header" style="background: #ffe8e8;">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-auto">
                            <img src="{{asset('assets/img/safe/symb.png')}}" style="max-width: 50px;">
                        </div>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">Error</h3>
                            <p class="uk-text-meta uk-margin-remove-top">Something went wrong</p>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body uk-text-center">                    
                    @switch($error_type)
                        @case(1)
                            <p>It seems that user with SAFE Username <span class="uk-label">{{$safe_id}}</span> already exists. <br>Try to login instead.</p>
                            @break

                        @case(2)
                            <p>It seems that user with SAFE Username <span class="uk-label">{{$safe_id}}</span> does not exists or has been registered for this app.</p>
                            @break

                        @case(3)
                            <p>It seems that user with SAFE Username <span class="uk-label">{{$safe_id}}</span> has been registered for this app already. Try to login.</p>
                            @break
                        @default
                            <p>{{$e ?? 'Error description not available'}}</p>

                    @endswitch
                </div>                    
            </div>
        </div>

    </div>
</div>

@include('includes.footer_demo_section')

@endsection
