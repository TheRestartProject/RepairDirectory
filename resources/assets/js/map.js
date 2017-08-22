const $ = require('jquery');
const renderBusiness = require('./components/business');
const {hideElement, showElement, enableElement, disableElement} = require('./util');

let map;
let markers = [];
let $businessPopup;
let $businessListContainer;
let $searchButton;
let $closeButton;

$(document).ready(() => {
    $businessPopup = $('#business-popup');
    $businessListContainer = $('#business-list-container');
    $searchButton = $('#submit');
    $closeButton = $('#business-popup-close');

    // add form handler
    $('#search').submit(onSearch);

    // enable/disable search button
    $('#location').keyup(function () {
        const $location = $(this);
        if ($location.val()) {
            enableElement($searchButton);
        } else {
            disableElement($searchButton);
        }
    });

    // close button should hide the displayed business
    $closeButton.click(hideRepairer);
});

function initMap() {
    const isMobile = $(window).width() < 768; // matches bootstrap sm/md breakpoint

    map = new google.maps.Map(document.getElementById(isMobile ? 'map-mobile' : 'map-desktop'), {
        zoom: 13,
        center: {lat: 51.5715356, lng: 0.1332412}
    });

    map.addListener('click', function () {
        hideRepairer();
    });
}

function onSearch(e) {
    e.preventDefault();

    const query = {
        location: $('[name="location"]').val(),
        category: $('[name="category"]').val(),
        radius: 5
    };

    doSearch(query);
}

function doSearch(query) {
    disableElement($searchButton);
    $.get('/map/api/business/search', query, ({searchLocation, businesses}) => {
        clearMap();
        if (searchLocation) {
            map.setCenter({lat: searchLocation.latitude, lng: searchLocation.longitude});
        }
        enableElement($searchButton);
        showElement($businessListContainer);
        businesses.forEach(addRepairer);
        $businessListContainer
            .find('.business-list-container__result-count')
            .text(businesses.length + ((businesses.length === 1) ? ' result ' : ' results ') + 'in your area');
    });
}

function clearMap() {
    hideRepairer();
    markers.forEach(marker => {
        marker.setMap(null);
    });
    markers = [];
    $('.business-list__item').remove();
}

function addRepairer(business) {
    const marker = new google.maps.Marker({
        position: {lat: business.geolocation.latitude, lng: business.geolocation.longitude},
        map: map,
        title: business.name
    });
    marker.addListener('click', function () {
        scrollToRepairer(business);
        showRepairer(business);
    });
    markers.push(marker);

    const $business = $(`
        <li role="button" class="business-list__item" id="business-${business.uid}">
            ${renderBusiness(business, true)}
        </li>
    `);

    $business.click(() => {
        showRepairer(business);
    });

    $('.business-list').append($business);
}

function scrollToRepairer(business) {
    const $sidebar = $('.sidebar');
    const $business = $sidebar.find('#business-' + business.uid);
    $sidebar.animate(({scrollTop: $business.offset().top - $sidebar.offset().top + $sidebar.scrollTop() - 100}));
}

function showRepairer(business) {
    map.setCenter({lat: business.geolocation.latitude, lng: business.geolocation.longitude});
    map.setZoom(15);

    $businessPopup.find('.business-popup__content').html(renderBusiness(business));

    showElement($businessPopup);

    $('.business-list__item').each(function () {
        const $item = $(this);
        if ($item.attr('id') === 'business-' + business.uid) {
            $item.removeClass('business-list__item--inactive');
        } else {
            $item.addClass('business-list__item--inactive')
        }
    })
}

function hideRepairer() {
    hideElement($businessPopup);
    $('.business-list__item').each(function () {
        const $item = $(this);
        $item.removeClass('business-list__item--inactive')
    })
}

module.exports = {initMap};
