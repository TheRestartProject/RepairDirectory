const $ = require('jquery')
const combobox = require('./combobox')
const {showElement, hideElement, enableElement, disableElement} = require('./util')

window.jQuery = $

require('bootstrap')

$(document).ready(() => {
  const $filter = $('#DataTables_Table_0_filter').find('input')
  // remember admin table filter
  $filter.change(function () {
    const $input = $(this)
    const value = $input.val()
    if (window.localStorage) {
      window.localStorage.filter = value
    }
  })

  // populate filter from local storage
  if (window.localStorage && window.localStorage.filter) {
    $filter.val(window.localStorage.filter)
    const e = $.Event('keyup')
    e.which = 50
    $filter.trigger(e)
  }

  // set up slider
  const $slider = $('#positiveReviewPcRange')
  const $sliderValue = $('#positiveReviewPc')
  $slider.change(function () {
    $sliderValue.val($slider.val())
  })
  $sliderValue.blur(function () {
    $slider.val($sliderValue.val())
  })

  // set up comboboxes
  const $localArea = $('#localArea')
  const $productsRepaired = $('#productsRepaired')
  const $authorisedBrands = $('#authorisedBrands')
  combobox($localArea, 'localArea', false)
  combobox($productsRepaired, 'productsRepaired')
  combobox($authorisedBrands, 'authorisedBrands')

  // set up on-the-fly validation for all elements with the 'validate' class
  $('.validate').each(function () {
    const $input = $(this)
    const field = $input.attr('name')
    const $error = $(`<small class="business-error hidden" id="${field}-error"></small>`)
    $error.insertAfter($input)
    $input.blur(function () {
      $.get('/map/admin/business/validate-field', {field: $input.attr('name'), value: $input.val()}, response => {
        if (response) {
          $error.text(response)
          showElement($error)
        } else {
          hideElement($error)
        }
      })
    })
  })

  // set up review url scraping
  const $reviewSourceUrl = $('#reviewSourceUrl')
  const $derivedElements = $('#reviewSourceUrl,#reviewSource,#positiveReviewPc,#positiveReviewPcRange,#averageScore')
  $reviewSourceUrl.blur(
    function () {
      disableElement($derivedElements)
      $.ajax('/admin/business/scrape-review', {
        data: {'url': $reviewSourceUrl.val()},
        success: function (response) {
          if (response.reviewSource) {
            $('#reviewSource').find('option')
              .each(function () {
                const $option = $(this)
                if ($option.val() === response.reviewSource) {
                  $option.attr('selected', '')
                } else {
                  $option.removeAttr('selected')
                }
              })
          }
          if (response.reviewAggregation) {
            const $positiveReviewPc = $('#positiveReviewPc')
            const $positiveReviewPcRange = $('#positiveReviewPcRange')
            const $averageScore = $('#averageScore')
            const $numberOfReviews = $('#numberOfReviews')

            $positiveReviewPc.val(response.reviewAggregation.positiveReviewPc || $positiveReviewPc.val() || 0)
            $positiveReviewPcRange.val(response.reviewAggregation.positiveReviewPc || $positiveReviewPc.val() || 0)
            $averageScore.val(response.reviewAggregation.averageScore || $averageScore.val() || 0)
            $numberOfReviews.val(response.reviewAggregation.numberOfReviews || $numberOfReviews.val() || '')
          }
          enableElement($derivedElements)
        },
        error: function (response) {
            console.log("my object: %o", response);
          enableElement($derivedElements)
        }
      })
    }
  )

  // set up delete button and popup
  const $delete = $('#delete')
  const $deletePopup = $('#delete-popup')
  const $cancelDelete = $('#cancel-delete')
  const $confirmDelete = $('#confirm-delete')
  $delete.click(() => showElement($deletePopup))
  $cancelDelete.click(() => hideElement($deletePopup))
  $confirmDelete.click(() => hideElement($deletePopup))
})
