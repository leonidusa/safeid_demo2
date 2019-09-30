@if ($errors->any())
    <div class="uk-alert-danger uk-margin-remove" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul class="uk-list uk-list-bullet uk-list-divider">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        </ul>
    </div>
@endif