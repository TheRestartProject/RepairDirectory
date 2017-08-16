const $ = require('jquery');
var $slider = $("#positiveReviewPcRange");
var $sliderValue = $("#positiveReviewPc");

$slider.change(function () {
    console.log("slider.change")
    $sliderValue.val($slider.val());
});

$sliderValue.blur(function () {
    console.log("sliderValue.blur")
    $slider.val($sliderValue.val());
});