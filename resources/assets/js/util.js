function showElement ($el) {
  $el.removeClass('d-none')
}

function hideElement ($el) {
  $el.addClass('d-none')
}

function enableElement ($el) {
  $el.removeAttr('disabled')
}

function disableElement ($el) {
  $el.attr('disabled', '')
}

module.exports = { showElement, hideElement, enableElement, disableElement }
