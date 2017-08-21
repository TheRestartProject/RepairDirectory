const $ = require('jquery');
const {hideElement, showElement, enableElement, disableElement} = require('./util');

let map;
let markers = [];
let $businessPopup;
let $businessListContainer;
let $searchButton;

$(document).ready(() => {
    $businessPopup = $('#business-popup');
    $businessListContainer = $('#business-list-container');
    $searchButton = $('#submit');

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
    $.get('/map/api/business/search', query, ({ searchLocation, businesses }) => {
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
            ${formatBusinessHeader(business, true)}
            ${formatBusinessDetails(business)}            
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
    $sidebar.animate(({ scrollTop: $business.offset().top - $sidebar.offset().top + $sidebar.scrollTop() - 100 }));
}

function showRepairer(business) {
    map.setCenter({lat: business.geolocation.latitude, lng: business.geolocation.longitude});
    map.setZoom(15);

    $businessPopup.html(`
        <div class="business-popup__heading">
            ${formatBusinessHeader(business)}
        </div>
        <div class="business-popup__details">
            ${formatBusinessDetails(business)}            
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

function formatBusinessHeader(business, compact = false) {
    let markup = '';
    markup += `<h2>${business.name}</h2>`;
    if (business.averageScore && !compact) {
        markup += `
            <div class="business-details__average-score">
                <h2>${business.averageScore} / 5</h2>
                <span>stars</span>
            </div>
        `;
    }
    if (business.positiveReviewPc) {
        markup += `
            <div class="business-details__positive-review-percentage">
                <h2>${business.positiveReviewPc}%</h2>
                <span>positive reviews</span>
            </div>
        `;
    }
    if (!compact) {
        markup += `<p class="business-details__description">${business.description}</p>`;
    }
    return markup;
}

function formatBusinessDetails(business) {
    let markup = '';

    let $categories = $('<ul class="business-details__categories"></ul>');
    business.categories.forEach(category => {
        $categories.append(`<li>${category}</li>`);
    });

    markup += $categories[0].outerHTML;

    if (business.website) {
        markup += `
        <p class="business-detail">
            <span class="fa fa-globe"></span>
            <a href="${business.website}">${business.website}</a>
        </p>`
    }

    if (business.email) {
        markup += `
        <p class="business-detail">
            <span class="fa fa-envelope-o"></span>
            <a href="mailto:${business.email}">${business.email}</a>
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
