const $ = require('jquery')
const renderBusiness = require('./components/business')
const {hideElement, showElement, enableElement, disableElement} = require('./util')

window.jQuery = $

let isMobile
let map
let businesses = []
let markers = []
let $businessPopup
let $businessListContainer
let $searchButton
let $closeButton

$(document).ready(() => {
  $businessPopup = $('#business-popup')
  $businessListContainer = $('#business-list-container')
  $searchButton = $('#submit')
  $closeButton = $('#business-popup-close')

  // add form handler
  $('#search').submit(onSearch)

  // enable/disable search button
  $('#location').keyup(function (e) {
    if (e.which === 13) {
      return
    }
    const $location = $(this)
    if ($location.val()) {
      enableElement($searchButton)
    } else {
      disableElement($searchButton)
    }
  })

  // close button should hide the displayed business
  $closeButton.click(triggerHideRepairer)

  // back and forward browser button support
  window.onhashchange = function () {
    if (window.location.hash && window.location.hash.length > 1) {
      let business = null
      let marker = null
      const uid = parseInt(window.location.hash.substring(1), 10)
      businesses.forEach(b => {
        if (parseInt(b.uid, 10) === uid) {
          business = b
        }
      })
      markers.forEach(m => {
        if (parseInt(m.businessUid, 10) === uid) {
          marker = m
        }
      })
      if (business && marker) {
        showRepairer(business, marker)
      }
      window.localStorage.hash = uid
    } else {
      hideRepairer()
      window.localStorage.hash = ''
    }
  }

  // search for businesses on page load
  onSearch(null, () => {
    window.location.hash = (window.localStorage && window.localStorage.hash) || ''
  })
})

function initMap () {
  isMobile = $(window).width() < 768 // matches bootstrap sm/md breakpoint

  map = new window.google.maps.Map(document.getElementById(isMobile ? 'map-mobile' : 'map-desktop'), {
    zoom: 13,
    center: {lat: 51.5715356, lng: 0.1332412}
  })

  map.addListener('click', function () {
    triggerHideRepairer()
  })
}

function onSearch (e, callback) {
  if (e) {
    e.preventDefault()
  }

  const location = $('[name="location"]').val()
  const category =  $('[name="category"]').val()

  if (location || category) {
    const query = {
      location,
      category,
      radius: 5
    }

    trackSearch(query.category)

    doSearch(query, callback)
  }
}

function doSearch (query, callback) {
  disableElement($searchButton)
  $.get('/map/api/business/search', query, ({searchLocation, businesses: _businesses}) => {
    clearMap()
    businesses = _businesses
    if (searchLocation) {
      map.setCenter({lat: searchLocation.latitude, lng: searchLocation.longitude})
    }
    enableElement($searchButton)
    showElement($businessListContainer)
    businesses.forEach(addRepairer)
    let resultCountText
    if (!businesses.length) {
      resultCountText = 'Unfortunately, there are no results in your area'
    } else {
      resultCountText = businesses.length + ((businesses.length === 1) ? ' result ' : ' results ') + 'in your area'
    }
    $businessListContainer
      .find('.business-list-container__result-count')
      .text(resultCountText)
    if (callback && typeof callback === 'function') {
      callback()
    }
  })
}

function clearMap () {
  triggerHideRepairer()
  markers.forEach(marker => {
    marker.setMap(null)
  })
  markers = []
  $('.business-list__item').remove()
}

function addRepairer (business) {
  const marker = new window.google.maps.Marker({
    icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
    position: {lat: business.geolocation.latitude, lng: business.geolocation.longitude},
    map: map,
    title: business.name
  })
  marker.businessUid = business.uid

  marker.addListener('click', function () {
    scrollToRepairer(business)
    triggerShowRepairer(business.uid)
  })
  markers.push(marker)

  const $business = $(`
        <li role="button" class="business-list__item" id="business-${business.uid}">
            ${renderBusiness(business, true)}
        </li>
    `)

  $business.click(() => {
    triggerShowRepairer(business.uid)
  })

  $('.business-list').append($business)
}

function scrollToRepairer (business) {
  const $sidebar = $('.sidebar')
  const $business = $sidebar.find('#business-' + business.uid)
  $sidebar.animate(({scrollTop: $business.offset().top - $sidebar.offset().top + $sidebar.scrollTop() - 100}))
}

function triggerShowRepairer (uid) {
  window.location.hash = uid
}

function showRepairer (business, marker) {
  trackRepairerSelection(business)

  const mapOffset = isMobile ? 0 : 0.025

  resetMarkers()

  marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png')
  map.setCenter({lat: business.geolocation.latitude + mapOffset, lng: business.geolocation.longitude})

  $businessPopup.find('.business-popup__content').html(renderBusiness(business))

  showElement($businessPopup)

  $('.business-list__item').each(function () {
    const $item = $(this)
    if ($item.attr('id') === 'business-' + business.uid) {
      $item.addClass('business-list__item--active')
      $item.removeClass('business-list__item--inactive')
    } else {
      $item.addClass('business-list__item--inactive')
      $item.removeClass('business-list__item--active')
    }
  })
}

function triggerHideRepairer () {
  window.location.hash = ''
}

function hideRepairer () {
  hideElement($businessPopup)
  $('.business-list__item').each(function () {
    const $item = $(this)
    $item.removeClass('business-list__item--inactive')
    $item.removeClass('business-list__item--active')
  })
  resetMarkers()
}

function resetMarkers () {
  markers.forEach(marker => {
    marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png')
  })
}

function trackSearch (category) {
  window.ga('send', 'event', 'search', 'submit', category || 'All Categories', {'transport': 'beacon'})
}

function trackRepairerSelection (business) {
  const value = [business.name, business.address, business.postcode].join(', ')
  window.ga('send', 'event', 'map', 'select', value, {'transport': 'beacon'})
}

module.exports = {initMap}
