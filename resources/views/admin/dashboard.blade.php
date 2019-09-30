@extends('layouts.admin')

@section('title') {{$meta_title}} @endsection

@section('main-content')
<div class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
    <div class="uk-container">
        @include('shared.errors-uikit')
        @include('shared.notify-uikit') 

        <div class="uk-h3">{{$page_heading}}</div>

            <div class="uk-grid uk-margin uk-child-width-1-1@m" uk-grid>
                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            <h3 class="uk-card-title">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-expand" uk-leader>Total users</div>
                                    <div>{{ $users->count()}}</div>
                                </div>                                
                            </h3>
                        </div>
                        <div class="uk-card-body">
                            <ul class="uk-list uk-list-bullet">
                                @foreach ($users as $user)
                                <li>
                                    <b>{{$user->name}}</b> {{$user->email}}<hr>
                                    GID: {{$user->google_id ? $user->google_id : 'N/A'}}
                                </li>
                                @endforeach
                            </ul>
                        </div>                        
                    </div>
                </div>
                                            
            </div>

        </div>
    </div>
</div>

@endsection