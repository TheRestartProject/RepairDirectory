// called when the Google Maps JavaScript API has loaded
window.initMap = function () {
    var center;
    if (window.geolocation) {
        center = {lat: window.geolocation.latitude, lng: window.geolocation.longitude};
    } else {
        center = {lat: 51.5074, lng: -0.1278};
    }

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: center
    });

    map.addListener('click', function () {
       hideRepairer();
    });

    window.businesses.forEach(function (business) {
        var marker = new google.maps.Marker({
            position: { lat: business.geolocation.latitude, lng: business.geolocation.longitude },
            map: map,
            title: business.name
        });
        marker.addListener('click', function() {
            map.setZoom(12);
            map.setCenter(marker.getPosition());
            showRepairer(business);
        });
    });
};

function showRepairer(business) {
    hideElement(document.getElementById('business-details-placeholder'));

    var detailsElement = document.getElementById('business-details');
    detailsElement.innerHTML = '<h2>' + business.name + '</h2>' +
        '<p>' + business.description + '</p>' +
        '<p>' + (business.address.split(',').join('<br/>')) + '<br/>' + business.postcode + '</p>';

    showElement(detailsElement);
}

function hideRepairer() {
    hideElement(document.getElementById('business-details'));
    showElement(document.getElementById('business-details-placeholder'));
}

function showElement(element) {
    var classNames = element.getAttribute('class').split(' ');
    var hiddenIndex = classNames.indexOf('hidden');
    if (hiddenIndex > -1) {
        classNames.splice(hiddenIndex, 1);
    }
    element.setAttribute('class', classNames.join(' '));
}

function hideElement(element) {
    var classNames = element.getAttribute('class').split(' ');
    var hiddenIndex = classNames.indexOf('hidden');
    if (hiddenIndex === -1) {
        classNames.push('hidden');
    }
    element.setAttribute('class', classNames.join(' '));
}
