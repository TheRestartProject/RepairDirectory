@extends('layout')

@section('content')

    <div class="row no-gutter">
        <div class="col-xs-12 col-sm-3 sidebar">
            <div class="sidebar__logo">
                <img src="/images/logo.png">
            </div>
            <div class="sidebar__content">
                <h3 class="sidebar__header">Restart repair directory</h3>
                <p class="sidebar__copy">Find a local business to repair your stuff.</p>
                <form id="search">
                    <div class="row no-gutter">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="location">Postcode</label>
                                <input id="location" name="location" class="form-control sidebar__input">
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutter">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-control sidebar__select">
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
                    <div class="row no-gutter">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-primary sidebar__button">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row no-gutter">
                    <div id="business-details" class="col-xs-12 hidden"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 map">
            <div id="map"></div>
        </div>
    </div>

    <script async defer onload="initMap()"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqzOdSRgPAZO6wC_oxOOkb7lkarq0PjT8"></script>

@endsection