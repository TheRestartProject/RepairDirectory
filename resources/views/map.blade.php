@extends('layout')

@section('content')

    <form id="search">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="location">Postcode</label>
                    <input id="location" name="location" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="form-control">
                        <option value="" selected>All</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <button class="btn btn-primary form-group">Search</button>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="map__container">
                <div id="map"></div>
            </div>
        </div>
        <div id="business-details" class="col-xs-12 col-md-4 hidden"></div>
        <div id="business-details-placeholder" class="col-xs-12 col-md-4">
            <h2>All repairers</h2>
            <p>Select an individual repairer to view details</p>
        </div>

    </div>

    <script async defer onload="initMap()"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqzOdSRgPAZO6wC_oxOOkb7lkarq0PjT8"></script>

@endsection