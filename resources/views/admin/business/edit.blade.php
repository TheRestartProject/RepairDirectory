@extends('admin.layout')

@section('content')
    <h2>{{ $isCreate ? 'New' : 'Edit' }} Business</h2>

    <form class="row" action="{{ $formAction }}" method="post">

        {{ csrf_field() }}

        {{ method_field($formMethod) }}

        <div class="col-xs-12 col-md-4">
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
                <label for="city">City</label>
                <input id="city" name="city"
                          class="form-control">{{ $business->getCity() }}</input>
            </div>

            <div class="form-group">
                <label for="borough">Borough</label>
                <input id="borough" name="borough"
                          class="form-control">{{ $business->getBorough() }}</input>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          class="form-control">{{ $business->getDescription() }}</textarea>
            </div>

            <div class="form-group">
                <label for="landline">Landline</label>
                <input id="landline" name="landline"
                          class="form-control">{{ $business->getLandline() }}</input>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input id="mobile" name="mobile"
                          class="form-control">{{ $business->getMobile() }}</input>
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input id="website" name="website"
                          class="form-control">{{ $business->getWebsite() }}</input>
            </div>

            <div>
                <button class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
@endsection