const $ = require('jquery');
var $slider = $("#positiveReviewPcRange");
var $sliderValue = $("#positiveReviewPc");
console.log($slider.val())
console.log($sliderValue.val())
console.log("HELLO!")


$slider.change(function () {
    console.log("slider.change")
    $sliderValue.val($slider.val());
});

$sliderValue.blur(function () {
    console.log("sliderValue.blur")
    $slider.val($sliderValue.val());
});