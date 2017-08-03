/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

// called when the Google Maps JavaScript API has loaded
window.initMap = function () {
    var londonLatLng = { lat: 51.5074, lng: -0.1278 };

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: londonLatLng
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
        marker.addListener('click', function () {
            map.setZoom(12);
            map.setCenter(marker.getPosition());
            showRepairer(business);
        });
    });
};

function showRepairer(business) {
    hideElement(document.getElementById('business-details-placeholder'));

    var detailsElement = document.getElementById('business-details');
    detailsElement.innerHTML = '<h2>' + business.name + '</h2>' + '<p>' + business.description + '</p>' + '<p>' + business.address.split(',').join('<br/>') + '<br/>' + business.postcode + '</p>';

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

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);