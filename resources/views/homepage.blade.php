@extends('layouts.master')
@section('title') {{$meta_title}} @endsection

@section('main-content')

<div class="uk-section uk-section-default uk-background-contain uk-background-center-left uk-background-norepeat" uk-parallax="bgy: -100" style="background-image: url({{asset('assets/img/bg/bg_02_s.jpg')}})">
    <div class="uk-container" >
        @include('shared.errors-uikit')
        @include('shared.notify-uikit')
        <h1 class="uk-text-center">{{$page_heading}}</h1>
        
        @if(!Auth::check())
        <div id="loginsection" class="uk-card uk-card-default uk-margin-auto uk-width-1-2@m">          
            
            <div class="uk-card-header">
                <h3 class="uk-card-title">Welcome!</h3>
            </div>
            <div class="uk-card-body">
                <p>Welcome to the hottest coupon codes of the day!</p>
                <p>Secret coupon codes are just few clicks away.</p>
                <p>Logged in members get to see them all.</p>
            </div>
            <div class="bg-orange uk-card-footer uk-flex uk-flex-between">                                          
                <a href="{{ route('login') }}" class="uk-button uk-button-primary">
                    <span class="uk-margin-small-right" uk-icon="icon: sign-in"></span>
                    <span>login</span>
                </a>               
            
                <a href="{{ route('register') }}" class="uk-button uk-button-secondary">
                    <span class="uk-margin-small-right" uk-icon="icon: lock"></span>
                    <span>register</span>
                </a>                
            </div>
        </div>
        @endif
    </div>
</div>

<div class="uk-section uk-section-xsmall uk-section-secondary">
    <div class="uk-container" >        
        <h3 class="uk-heading-line uk-text-center"><span>HOT deals/coupons</span></h3>
    </div>
</div>
<div class="uk-section uk-section-default">
    <div class="uk-container" >
        <div class="uk-child-width-1-3@m uk-grid-match" uk-grid uk-scrollspy="target: > div; cls:uk-animation-fade; delay: 100">        
            <div>
                <div class="uk-card uk-card-default uk-card-hover uk-flex uk-flex-between uk-flex-column">
                    <div class="uk-card-media-top">
                        <img src="{{asset('assets/img/var/code_02.jpg')}}" alt="">
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-heading-divider">HP Pavilion X360</h3>
                        <p>The end of the month has arrived and Best Buy is celebrating with a fire sale on many of our favorite premium laptops.</p>
                    </div>
                    <div class="bg-success uk-card-footer uk-flex uk-flex-between uk-light">
                        <div class="uk-text-bold">
                            Save $300
                        </div>
                        @if(!Auth::check())
                        <div>
                            <a href="loginsection" uk-scroll>Get the code</a>
                        </div>
                        @else
                        <div>
                            <span class="uk-label" title="Use this code at checkout" uk-tooltip>PFU23854</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-hover uk-flex uk-flex-between uk-flex-column">
                    <div class="uk-card-media-top">
                        <img src="{{asset('assets/img/var/code_01.jpg')}}" alt="">
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-heading-divider">Dell XPS</h3>
                        <p>This machine packs a 13.3-inch QHD+ 3200 x 1800 touch LCD, 1.3GHz Core i7-7Y75 processor, 16GB of RAM, and a generous 512GB SSD</p>
                    </div>
                    <div class="bg-orange uk-card-footer uk-flex uk-flex-between">
                        <div class="uk-text-bold uk-text-danger">
                            60% OFF
                        </div>
                        @if(!Auth::check())
                        <div>
                            <a href="loginsection" uk-scroll>Get the code</a>
                        </div>
                        @else
                        <div>
                            <span class="uk-label" title="Use this code at checkout" uk-tooltip>LOLURFUNNY</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-hover uk-flex uk-flex-between uk-flex-column">
                    <div class="uk-card-media-top">
                        <img src="{{asset('assets/img/var/code_03.jpg')}}" alt="">
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-heading-divider">APPLE MACBOOK AIR</h3>
                        <ul>
                            <li>Retina display with True Tone</li>
                            <li>Processor: 1.86 GHz Intel Core i5 processor with Turbo Boost up to 3.6GHz</li>
                            <li>RAM: 8GB 2133MHz LPDDR3 memory</li>
                            <li>Hard Drive: 512GB SSD storage</li>
                        </ul>
                    </div>
                    <div class="bg-red uk-card-footer uk-flex uk-flex-between uk-light">
                        <div class="uk-text-bold">
                            Yours for $199
                        </div>
                        @if(!Auth::check())
                        <div>
                            <a href="loginsection" uk-scroll>Get the code</a>
                        </div>
                        @else
                        <div>
                            <span class="uk-label" title="Use this code at checkout" uk-tooltip>YEAHRIGHT</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

@include('includes.spinner')
@include('includes.footer_demo_section')

@endsection