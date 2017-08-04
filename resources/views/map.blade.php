@extends('layout')

@section('content')

    <form id="search" class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="search">Search by postcode</label>
                <input id="search" name="search" class="form-control">
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