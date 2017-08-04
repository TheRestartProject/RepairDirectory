function showElement($el) {
    $el.removeClass('hidden');
}

function hideElement($el) {
    $el.addClass('hidden');
}

module.exports = { showElement, hideElement };
