@extends('layouts.master')

@section('title')
{{$meta_title}}
@endsection

@section('main-content')
<div class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
    <div class="uk-container">
        @include('shared.errors-uikit')
        @include('shared.notify-uikit') 

        <div class="uk-h3">{{$page_heading}}</div>
                    
            <form action="{{ route('userProfilePost') }}" method="POST">
            @csrf
                <div class="uk-grid uk-margin uk-child-width-1-3@m" uk-grid>
                    <div>
                        <label class="uk-form-label" for="name">User name *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="name" value="{{$user->name}}" name="name" required>
                        </div>
                    </div> 
                    <div>
                        <label class="uk-form-label" for="email">Email Address</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="email" name="email" value="{{$user->email}}">
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="aid">SAFE Username</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="aid" name="aid" value="{{$user->anchor_id}}">
                        </div>
                    </div>
                </div>

                <div class="uk-grid uk-margin uk-child-width-1-3@m" uk-grid>
                    <div>
                        <label class="uk-form-label" for="password">Current Password</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" name="password" id="password" type="password">
                        </div>
                    </div>

                    <div>
                        <label class="uk-form-label" for="new_password">New Password</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" name="new_password" id="new_password" type="password">
                        </div>
                    </div>

                    <div>
                        <label class="uk-form-label" for="new_password_confirmation">New Password Confirmation</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" name="new_password_confirmation" id="new_password_confirmation"type="password">
                        </div>
                    </div>
                </div>
                                
                <div class="uk-margin">
                    <button type="submit" class="uk-button uk-button-primary">Save Changes</button>
                </div>
                        
            </form>
              
        </div>
    </div>
</div>
@if(!$user->anchor_id && !$user->prompt_made)
    @include('includes.after_login_modal')
@elseif (!$user->anchor_id && $user->prompt_made)
    @include('includes.after_reconnect_modal')    
@endif

@endsection