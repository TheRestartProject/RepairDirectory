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

