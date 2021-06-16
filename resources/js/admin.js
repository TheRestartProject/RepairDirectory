const $ = require('jquery')
const combobox = require('./combobox')
const {showElement, hideElement, enableElement, disableElement} = require('./util')

window.jQuery = $

require('bootstrap')

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

// Set up internationalisation.  translations.js is built in webpack.mix.js from the PHP lang folder.
import lang from 'lang.js';
import translations from './translations.js';
const Lang = new lang()
Lang.setFallback('en')
Lang.setMessages(translations)

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
  const $productsRepaired = $('#productsRepaired')
  const $authorisedBrands = $('#authorisedBrands')
  combobox($productsRepaired, 'productsRepaired')
  combobox($authorisedBrands, 'authorisedBrands')

  // set up on-the-fly validation for all elements with the 'validate' class
  $('.validate').each(function () {
    const $input = $(this)
    const field = $input.attr('name')
    const $error = $(`<small class="business-error hidden" id="${field}-error"></small>`)
    $error.insertAfter($input)
    $input.blur(function () {
      $.get('/admin/business/validate-field', {field: $input.attr('name'), value: $input.val()}, response => {
        if (response) {
          $error.text(response)
          showElement($error)
        } else {
          hideElement($error)
        }
      })
    })
  })

  // set up delete button and popup
  const $delete = $('#delete')
  const $deletePopup = $('#delete-popup')
  const $cancelDelete = $('#cancel-delete')
  const $confirmDelete = $('#confirm-delete')
  $delete.click(() => showElement($deletePopup))
  $cancelDelete.click(() => hideElement($deletePopup))
  $confirmDelete.click(() => hideElement($deletePopup))

  // Create a mixin for translation.
  Vue.mixin({
    computed: {
      $lang() {
        // We want this to be available in all components.
        return Lang
      }
    },
    methods: {
      __(key) {
        // This means we can use __('key') in Vue templates in the same way as we are used to in Laravel
        // templates.
        return this.$lang.get(key)
      }
    }
  })

  // Initialise Vue instances on any divs which have asked for it.
  //
  // Normally you'd initialise one instance on a single top-level div.  But we put content directly under body.
  // Initialising multiple instances is a bit more expensive, but not much.
  //
  // We need to list all the components we will use in here; they are stored in resources/assets/js/components.
  $(".vue").each(function(index) {
    new Vue({
      el: $(this).get(0),
      components: {
        'publishingstatus': require('./components/PublishingStatus.vue').default,
      }
    })
  })

  $(".vue-placeholder-large").hide()
})