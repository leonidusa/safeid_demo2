@extends('layouts.admin')
@section('title') {{$meta_title}} @endsection

@section('main-content')
<div class="uk-section uk-section-xsmall">
    <div class="uk-container">
        @include('shared.errors-uikit')
        @include('shared.notify-uikit') 

        <div class="uk-h3">{{$page_heading}}</div>

            <form action="{{ route('admin_settings_save', $service) }}" method="POST" class="uk-form-horizontal">
            @csrf
                <div class="uk-grid uk-margin uk-child-width-1-1@m" uk-grid>                   

                    <div>
                        <p>Add endpoints description here</p>
                    </div>

                    <div>
                        <label class="uk-form-label" for="client_id">client_id</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="client_id" name="client_id" value="{{$client_id}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="client_secret">client_secret</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="client_secret" name="client_secret" value="{{$client_secret}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="client_safe_id">client_safe_id</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="client_safe_id" name="client_safe_id" value="{{$client_safe_id}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="uri_oauth2">oauth2</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="uri_oauth2" name="uri_oauth2" value="{{$uri_oauth2}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="uri_signin">signin</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="uri_signin" name="uri_signin" value="{{$uri_signin}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="uri_prompt">prompt</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="uri_prompt" name="uri_prompt" value="{{$uri_prompt}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="uri_checkclientaid">checkclientaid</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="uri_checkclientaid" name="uri_checkclientaid" value="{{$uri_checkclientaid}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="uri_transaction">transaction</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="uri_transaction" name="uri_transaction" value="{{$uri_transaction}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="uri_consumer">consumer</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="uri_consumer" name="uri_consumer" value="{{$uri_consumer}}">                                
                        </div>
                    </div>
                    <div>
                        <label class="uk-form-label" for="uri_application">application</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="uri_application" name="uri_application" value="{{$uri_application}}">                                
                        </div>
                    </div>
                    

                </div>
               
                <div class="uk-margin-large uk-text-center">   
                    <button type="submit" class="uk-button uk-button-primary">Save Changes</button>
                </div>
                        
            </form>

        </div>
    </div>
</div>

@endsection