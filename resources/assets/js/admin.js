const $ = jQuery = require('jquery');
const combobox = require('./combobox');
const { enableElement, disableElement } = require('./util');

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

const $reviewSourceUrl = $("#reviewSourceUrl");
const $derivedElements = $("#reviewSourceUrl,#reviewSource,#positiveReviewPc,#positiveReviewPcRange,#averageScore");
$reviewSourceUrl.blur(
    function () {
        disableElement($derivedElements);
        $.get("/map/admin/business/scrape-review", { "url": $reviewSourceUrl.val() }, function (response) {
            if (response.reviewSource) {
                $('#reviewSource').find('option')
                    .each(function () {
                        const $option = $(this);
                        if ($option.val() === response.reviewSource) {
                            $option.attr('selected', '');
                        } else {
                            $option.removeAttr('selected');
                        }
                    })
            }
            if (response.reviewAggregation) {
                $('#positiveReviewPc').val(response.reviewAggregation.positiveReviewPc || 0);
                $('#positiveReviewPcRange').val(response.reviewAggregation.positiveReviewPc || 0);
                $('#averageScore').val(response.reviewAggregation.averageScore || 0);
                $('#numberOfReviews').val(response.reviewAggregation.numberOfReviews || '');
            }
            enableElement($derivedElements);
        })
    }
);
