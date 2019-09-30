@extends('layouts.admin')

@section('title')
    All Users
@endsection

@section('main-content')
<div class="uk-section uk-section-xsmall">
    @include('shared.errors-uikit')
    @include('shared.notify-uikit') 

    <div class="uk-h3">Admin user management</div>

    <table class="uk-table uk-table-divider uk-table-middle uk-table-small uk-table-striped uk-table-hover uk-text-small">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Email</th>
                <th><span uk-icon="icon: phone"></span></th>
                <th>Google ID</th>
                <th>SAFE ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>
                    <a href="#" uk-tooltip title="
                    Created:<br> {{$user->created_at->format('m/d/Y')}} ({{$user->created_at->diffForHumans()}})<br>
                    Updated:<br> {{$user->updated_at}} ({{$user->updated_at->diffForHumans()}})
                    ">
                        {{$user->name}}
                    </a>
                </td>
                <td>
                    @if($user->admin == true)
                        Admin
                    @else
                        User
                    @endif
                    
                </td>
                <td>{{$user->email}}</td>
                <td>{{$user->mobile}}</td>
                <td>{{$user->google_id}}</td>
                <td>{{$user->anchor_id ? $user->anchor_id : '-' }}</td>
                <td>
                    <a href="{{route('adminEditUser', $user->id)}}"class="uk-button uk-button-small uk-button-primary">
                        <span uk-icon="icon: pencil"></span> <span class="uk-visible@l"></span>
                    </a>
                    
                    <form method="POST" action="{{route('adminDeleteUser', $user->id)}}" class="uk-display-inline">
                        @csrf
                        <button type="submit" class="uk-button uk-button-small uk-button-danger" {!!$user->admin == 1 ? "disabled uk-tooltip title='Can not remove admin'": ""!!}>
                            <span uk-icon="icon: trash"></span> <span class="uk-visible@l"></span> 
                            
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection