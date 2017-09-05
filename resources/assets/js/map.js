const $ = require('jquery');
const renderBusiness = require('./components/business');
const {hideElement, showElement, enableElement, disableElement} = require('./util');

let isMobile;
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
    $('#location').keyup(function (e) {
        if (e.which === 13) {
            return;
        }
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
    isMobile = $(window).width() < 768; // matches bootstrap sm/md breakpoint

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

    trackSearch(query.category);

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
        let resultCountText;
        if (!businesses.length) {
            resultCountText = 'Unfortunately, there are no results in your area';
        } else {
            resultCountText = businesses.length + ((businesses.length === 1) ? ' result ' : ' results ') + 'in your area';
        }
        $businessListContainer
            .find('.business-list-container__result-count')
            .text(resultCountText);
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
        icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        position: {lat: business.geolocation.latitude, lng: business.geolocation.longitude},
        map: map,
        title: business.name
    });
    marker.addListener('click', function () {
        scrollToRepairer(business);
        showRepairer(business, marker);
    });
    markers.push(marker);

    const $business = $(`
        <li role="button" class="business-list__item" id="business-${business.uid}">
            ${renderBusiness(business, true)}
        </li>
    `);

    $business.click(() => {
        showRepairer(business, marker);
    });

    $('.business-list').append($business);
}

function scrollToRepairer(business) {
    const $sidebar = $('.sidebar');
    const $business = $sidebar.find('#business-' + business.uid);
    $sidebar.animate(({scrollTop: $business.offset().top - $sidebar.offset().top + $sidebar.scrollTop() - 100}));
}

function showRepairer(business, marker) {
    trackRepairerSelection(business);

    const mapOffset = isMobile ? 0 : 0.025;

    resetMarkers();

    marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
    map.setCenter({lat: business.geolocation.latitude + mapOffset, lng: business.geolocation.longitude});

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
    });
    resetMarkers();
}

function resetMarkers() {
    markers.forEach(marker => {
        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png')
    });
}

function trackSearch(category) {
    ga('send', 'event', 'search', 'submit', category || 'All Categories', { 'transport': 'beacon' });
}

function trackRepairerSelection(business) {
    const value = [business.name, business.address, business.postcode].join(', ');
    ga('send', 'event', 'map', 'select', value, { 'transport': 'beacon' });
}

module.exports = {initMap};
