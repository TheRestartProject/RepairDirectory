const $ = require('jquery');
const {hideElement, showElement} = require('./util');

let map;
let markers = [];
let $businessDetails, $businessDetailsPlaceholder;

$(document).ready(() => {
    $('#search').submit(onSearch);
});

function initMap() {
    $businessDetails = $('#business-details');
    $businessDetailsPlaceholder = $('#business-details-placeholder');

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: {lat: 51.5074, lng: -0.1278}
    });

    map.addListener('click', function () {
        hideRepairer();
    });

    doSearch();
}

function onSearch(e) {
    e.preventDefault();

    const query = {
        search: $('[name="search"]').val()
    };

    doSearch(query);
}

function doSearch(query) {
    $.get('/api/business/search', query, (businesses) => {
        clearMap();
        businesses.forEach(addRepairer);
    });
}

function clearMap() {
    markers.forEach(marker => {
        marker.setMap(null);
    });
    markers = [];
}

function addRepairer(business) {
    const marker = new google.maps.Marker({
        position: {lat: business.geolocation.latitude, lng: business.geolocation.longitude},
        map: map,
        title: business.name
    });
    marker.addListener('click', function () {
        showRepairer(business);
    });
    markers.push(marker);
}

function showRepairer(business) {
    hideElement($businessDetailsPlaceholder);

    $businessDetails.html(
        `
        <h2>${business.name}</h2>
        <p>${business.description}</p>
        ${business.address.split(',').join('<br/>')}
        ${business.postcode}
        `
    );

    showElement($businessDetails);
}

function hideRepairer() {
    hideElement($businessDetails);
    showElement($businessDetailsPlaceholder);
}

module.exports = {initMap};
