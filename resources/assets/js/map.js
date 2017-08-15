const $ = require('jquery');
const {hideElement, showElement} = require('./util');

let map;
let markers = [];
let $businessPopup;

$(document).ready(() => {
    $('#search').submit(onSearch);
    $businessPopup = $('#business-popup');
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

    doSearch();
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
    $.get('/map/api/business/search', query, ({ searchLocation, businesses }) => {
        clearMap();
        if (searchLocation) {
            map.setCenter({lat: searchLocation.latitude, lng: searchLocation.longitude});
        }
        businesses.forEach(addRepairer);
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
            <h2>${business.name}</h2>
            <p>${business.description}</p>
            ${formatContactDetails(business)}            
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
    console.log('scrolling to', $business.offset().top - $sidebar.offset().top + $sidebar.scrollTop());
    $sidebar.scrollTop(
        $business.offset().top - $sidebar.offset().top + $sidebar.scrollTop() - 100
    );
}

function showRepairer(business) {
    map.setCenter({lat: business.geolocation.latitude, lng: business.geolocation.longitude});
    map.setZoom(15);

    $businessPopup.html(`
        <div class="business-popup__heading">
            <h2>${business.name}</h2>
            <p>${business.description}</p>
        </div>
        <div class="business-popup__details">
            ${formatContactDetails(business)}            
        </div>
    `);

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

function formatContactDetails(business) {
    let markup = '';

    if (business.website) {
        markup += `
        <p class="business-detail">
            <span class="fa fa-globe"></span>
            <a href="${business.website}">${business.website}</a>
        </p>`
    }

    if (business.landline || business.mobile) {
        markup += `
        <p class="business-detail">
            <span class="fa fa-phone"></span>
            <span>${business.landline || business.mobile}</span>
        </p>`
    }

    const completeAddress = [business.address, business.city, business.postcode]
        .filter(Boolean)
        .join(', ');

    markup += `
    <p class="business-detail">
        <span class="fa fa-map-marker"></span>
        <span>${completeAddress}</span>
    </p>`;

    return markup;
}

module.exports = {initMap};
