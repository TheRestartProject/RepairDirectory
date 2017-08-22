@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a id="map" href="{{ route('map') }}" class="btn btn-primary">Go to map</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @if($loggedInUser === null)
                <form id="login-as-user" method="POST" action="{{ route('login') }}">

                    {{ csrf_field() }}

                    <select name="user_id">
                        @foreach($users as $user)
                            <option value="{{ $user->getUid() }}">{{ $user->getEmail() }}</option>
                        @endforeach
                    </select>

                    <button class="btn-primary">Login As</button>
                </form>
                @endif
            </div>
        </div>
    </div>

@endsection