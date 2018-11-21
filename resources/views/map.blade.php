@extends('layout')

@section('content')

    <div class="row no-gutter">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 sidebar">
            <div class="sidebar__logo">
                <img src="/images/map/logo.png">
            </div>
            <div class="sidebar__content">
                <h3 class="d-none sidebar__header">{{ __('map.header_title') }}</h3>
                <p class="sidebar__copy">{{ __('map.header_copy') }}</p>
                <form id="search" class="sidebar__search">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <div class="form-group">
                                <label for="location">{{ __('map.location.label') }}</label>
                                <input id="location" name="location" class="form-control sidebar__input"
                                       value="London, UK"
                                       placeholder="{{ __('map.location.placeholder') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="radius">{{ __('map.radius') }}</label>
                                <select id="radius" name="radius" class="form-control sidebar__select">
                                    @foreach($radiusOptions as $option)
                                        <option value="{{ $option }}" {{ $option == $selectedRadius ? 'selected' : '' }}>
                                            {{ __("map.radius_labels.$option") }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-8">
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
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="sidebar__button-label d-none d-lg-inline-block">Search</label>
                                <button id="submit" class="btn btn-primary sidebar__button" disabled>
                                    {{ __('map.search') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="map-mobile"></div>
                <div id="business-list-container" class="row no-gutter d-none">
                    <p class="business-list-container__result-count"></p>
                    <ul class="business-list col-xs-12"></ul>
                </div>
            </div>
        </div>
        <div id="map-desktop-container" class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
            <div id="map-desktop"></div>
            <div id="business-popup" class="business-popup d-none">
                <button id="business-popup-close" type="button" class="btn btn-default business-popup__close"><i class="fa fa-times"></i></button>
                <div class="business-popup__content"></div>
            </div>
        </div>
    </div>

    <script async defer onload="initMap()"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqzOdSRgPAZO6wC_oxOOkb7lkarq0PjT8"></script>

@endsection
