const $ = require('jquery');
var $slider = $("#positiveReviewPcRange");
var $sliderValue = $("#positiveReviewPc");

$slider.change(function () {
    $sliderValue.val($slider.val());
});

$sliderValue.blur(function () {
    $slider.val($sliderValue.val());
});