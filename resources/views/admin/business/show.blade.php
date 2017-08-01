@extends('admin.layout')

@section('content')
    <h1>New Business</h1>

    <form method="post" action="{{ route('admin.business.update', ['id' => $business->getUid()]) }}">

        {{ csrf_field() }}

        {{ method_field('put') }}

        <div>
            <label for="name">Name</label>
            <input id="name" name="name" value="{{ $business->getName() }}"/>
        </div>

        <div>
            <label for="address">Address</label>
            <input id="address" name="address" value="{{ $business->getAddress() }}"/>
        </div>

        <div>
            <label for="postcode">Postcode</label>
            <input id="postcode" name="postcode" value="{{ $business->getPostcode() }}"/>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" value="{{ $business->getDescription() }}"></textarea>
        </div>

        <div>
            <button>Save</button>
        </div>

    </form>
@endsection