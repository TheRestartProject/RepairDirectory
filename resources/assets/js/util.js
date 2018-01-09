function showElement ($el) {
  $el.removeClass('hidden')
}

function hideElement ($el) {
  $el.addClass('hidden')
}

function enableElement ($el) {
  $el.removeAttr('disabled')
}

function disableElement ($el) {
  $el.attr('disabled', '')
}

module.exports = { showElement, hideElement, enableElement, disableElement }
