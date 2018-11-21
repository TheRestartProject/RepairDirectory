@extends('layout')

@section('title', __('map.title'))

@section('content')

    <div class="row no-gutter">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 sidebar">
            <div class="sidebar__logo">
                <img src="/images/map/logo.png">
            </div>
            <div class="sidebar__content">
                <h3 class="d-none sidebar__header">{{ __('map.header_title') }}</h3>
                <p class="sidebar__copy">{{ __('map.header_copy') }} <span id="more-info">(More info <i class="fa fa-question-circle"></i>)</span></p>
                <form id="search" action="{{ config('map.share.base_url') }}" method="get" class="sidebar__search">
                    <div class="row">
                        <div class="col-12 col-xl-8">
                            <div class="form-group">
                                <label for="location">{{ __('map.location.label') }}</label>
                                <input id="location" name="location" class="form-control sidebar__input"
                                       value="{{ $selectedLocation }}"
                                       placeholder="{{ __('map.location.placeholder') }}">
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
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
                        <div class="col-12 col-xl-8">
                            <div class="form-group">
                                <label for="category">{{ __('map.category') }}</label>
                                <select id="category" name="category" class="form-control sidebar__select">
                                    <option value="" {{ empty($selectedCategory) ? 'selected' : '' }}>{{ __('map.category_all') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ $category == $selectedCategory ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
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
                    <div class="business-list-container__results-header">
                        <div class="business-list-container__result-count"></div>
                        <div class="share-link">
                            <a href="" id="open-share-url">Share results <i class="fa fa-share"></i></a>
                            <div id="share-url-container" class="share-link__container">
                                <button id="close-share-url" class="share-link__close-button">x</button>
                                <label>Share this link to share results</label>
                                <div class="share-link__input">
                                    <input id="share-url" value="{{ route('map') }}" readonly /><button id="copy-url"><i class="fa fa-fw fa-copy"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="business-list col-xs-12"></ul>
                </div>
            </div>
            <div id="more-info-popup" class="d-none">
                <button id="more-info-popup-close" type="button" class="btn btn-default"><i class="fa fa-times"></i></button>
                <div id="more-info-popup__content">
                    <h4>Broken gadget?</h4>
                    <p><strong>No time to fix it yourself or to bring it to a Restart Party in London?</strong> Search the Restart Repair Directory to find a reliable repair business in your area.</p>
                    <p><strong>This is a beta release</strong> and includes businesses in <strong>11 boroughs in London</strong>: Barnet, Camden, Enfield Hackney, Haringey, Islington and Waltham Forest in North London, and Barking and Dagenham, Newham, Havering, Redbridge in East London.</p>
                    <h4>Get involved</h4>

                    <p>You can help us grow the repair economy.</p>

                    <ul>
                        <li><a target="_blank" href="https://therestartproject.org/repairdirectory/about">Learn more about the Repair Directory</a>, and let us know what you think. Noticed a bug? Get in touch.</li>
                        <li>Help us improve the list of businesses in these 11 London boroughs. Send us an <a target="_blank" href="mailto:tech@therestartproject.org">email</a> if you notice an error or omission, or with your own recommended business.</li>
                        <li>Help us build the software. The Repair Directory is free, open-source software with the source code <a target="_blank" href="https://github.com/TheRestartProject/RepairDirectory">available on Github</a>. If you’re a coder, a designer, a UX person, or a tester, you can get involved.</li>
                    </ul>

                    <p>Mapping repair businesses in the 7 boroughs of North London was funded by a grant from the the North London Waste Authority Community Fund.</p>
                </div>
            </div>
        </div>
        <div id="map-desktop-container" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div id="map-desktop"></div>
            <div id="business-popup" class="business-popup d-none">
                <button id="business-popup-close" type="button" class="btn btn-default business-popup__close"><i class="fa fa-times"></i></button>
                <div class="business-popup__content"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script async defer onload="search()"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqzOdSRgPAZO6wC_oxOOkb7lkarq0PjT8"></script>
@endsection
