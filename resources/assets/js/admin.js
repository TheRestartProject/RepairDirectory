const $ = jQuery = require('jquery');
const combobox = require('./combobox');

const $slider = $("#positiveReviewPcRange");
const $sliderValue = $("#positiveReviewPc");

$slider.change(function () {
    $sliderValue.val($slider.val());
});

$sliderValue.blur(function () {
    $slider.val($sliderValue.val());
});

const $productsRepaired = $('#productsRepaired');
const $authorisedBrands = $('#authorisedBrands');

combobox($productsRepaired, 'productsRepaired');
combobox($authorisedBrands, 'authorisedBrands');

reviewSourceUrlEl = $("#reviewSourceUrl");
reviewSourceUrlEl.keyup(function () {
        console.log("He's a right proper logger")
        //TODO: make a request to review-scraping with the proper parameters
        console.log('%c right proper', 'font-size: 0.5rem;');
    }
);
