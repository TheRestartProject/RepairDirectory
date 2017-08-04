@extends('admin.layout')

@section('content')
    <h2>{{ $isCreate ? 'Edit' : 'New' }} Business</h2>

    <form class="row" action="{{ $formAction }}" method="post">

        {{ csrf_field() }}

        {{ method_field($formMethod) }}

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" name="name" class="form-control" value="{{ $business->getName() }}"/>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input id="address" name="address" class="form-control" value="{{ $business->getAddress() }}"/>
            </div>

            <div class="form-group">
                <label for="postcode">Postcode</label>
                <input id="postcode" name="postcode" class="form-control" value="{{ $business->getPostcode() }}"/>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          class="form-control">{{ $business->getDescription() }}</textarea>
            </div>

            <div>
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
@endsection