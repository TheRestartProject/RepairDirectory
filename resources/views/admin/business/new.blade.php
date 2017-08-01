@extends('admin.layout')

@section('content')
    <h1>New Business</h1>

    <form method="post" action="{{ route('admin.business.store') }}">

        {{ csrf_field() }}

        <div>
            <label for="name">Name</label>
            <input id="name" name="name"/>
        </div>

        <div>
            <label for="address">Address</label>
            <input id="address" name="address"/>
        </div>

        <div>
            <label for="postcode">Postcode</label>
            <input id="postcode" name="postcode"/>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div>
            <button>Save</button>
        </div>

    </form>
@endsection