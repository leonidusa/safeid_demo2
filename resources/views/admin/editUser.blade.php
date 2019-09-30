@extends('layouts.admin')

@section('title')
    Edit user {{$user->id}}
@endsection

@section('main-content')
<div class="uk-section uk-section-xsmall">
    <div class="uk-container">
        @include('shared.errors-uikit')
        @include('shared.notify-uikit') 

        <div class="uk-h3">Editing user "{{$user->name}}"</div>

            <form action="{{ route('adminUpdateUser', $user->id) }}" method="POST">
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
                        <label class="uk-form-label" for="perm">Access level</label>
                        <div class="uk-form-controls">
                            <input class="uk-checkbox" id="perm" type="checkbox" name="user" value="1" {{$user->user == true ? 'checked' : ''}}> User<br>
                            <input class="uk-checkbox" id="perm" type="checkbox" name="admin" value="1" {{$user->admin == true ? 'checked' : ''}}> Admin<br>
                        </div>
                    </div>
                </div>

                <div class="uk-grid uk-margin uk-child-width-1-3@m" uk-grid>
                    {{-- <div>
                        <label class="uk-form-label" for="password">Current Password</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" name="password" id="password" type="password">
                        </div>
                    </div> --}}
                    <div>
                        <label class="uk-form-label" for="anchor_id">SAFE ID</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" name="anchor_id" id="anchor_id" type="text" value="{{$user->anchor_id}}">
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

@endsection