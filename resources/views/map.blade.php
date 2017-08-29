@extends('layout')

@section('content')

    <div class="row no-gutter">
        <div class="col-xs-12 col-sm-3 sidebar">
            <div class="sidebar__logo">
                <img src="/images/map/logo.png">
            </div>
            <div class="sidebar__content">
                <h3 class="sidebar__header">{{ __('map.header_title') }}</h3>
                <p class="sidebar__copy">{{ __('map.header_copy') }}</p>
                <form id="search" class="sidebar__search">
                    <div class="row no-gutter">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="location">{{ __('map.location') }}</label>
                                <input id="location" name="location" class="form-control sidebar__input"
                                placeholder="E.G. Postcode">
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutter">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="category">{{ __('map.category') }}</label>
                                <select id="category" name="category" class="form-control sidebar__select">
                                    <option value="" selected>{{ __('map.category_all') }}</option>
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
                                <button id="submit" class="btn btn-primary sidebar__button" disabled>
                                    {{ __('map.search') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="map-mobile"></div>
                <div id="business-list-container" class="row no-gutter hidden">
                    <p class="business-list-container__result-count"></p>
                    <ul class="business-list col-xs-12"></ul>
                </div>
            </div>
        </div>
        <div id="map-desktop-container" class="col-xs-12 col-sm-9">
            <div id="map-desktop"></div>
            <div id="business-popup" class="business-popup hidden">
                <button id="business-popup-close" type="button" class="btn btn-default fa fa-times business-popup__close"></button>
                <div class="business-popup__content"></div>
            </div>
        </div>
    </div>

    <script async defer onload="initMap()"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqzOdSRgPAZO6wC_oxOOkb7lkarq0PjT8"></script>

@endsection