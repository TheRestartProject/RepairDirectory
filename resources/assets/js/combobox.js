const $ = require('jquery');

/**
 * Convert a text input into a combobox, where items are of type `field`
 *
 * @param $el
 * @param field
 */
function combobox ($el, field) {
    // do nothing if the element isn't present
    if ($el.length === 0) {
        return;
    }

    // don't submit the value of $el. instead submit the value of a hidden element that stores all selected items
    const name = $el.attr('name');
    $el.attr('name', '');

    const $hidden = $(`<input type="hidden" name="${name}">`);
    const $selected = $('<ul class="combobox__selected"></ul>');
    const $suggestions = $('<ul class="combobox__results"></ul>');

    $hidden.insertBefore($el);
    $selected.insertBefore($el);
    $suggestions.insertAfter($el);

    const initialItems = _stringToArray($el.val());
    initialItems.forEach(item => {
        _addToSelected(item, $selected, $hidden);
    });
    $el.val('');


    // clear the results when the element loses focus
    $el.blur(function () {
        // setTimeout to allow list items to be clicked
        setTimeout(() => $suggestions.empty(), 300);
    });

    // prevent form submit when enter is pressed
    $el.keydown(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            _addToSelected($el.val(), $selected, $hidden);
            $el.val('');
            return false;
        }
    });

    // when a key is released, query the API for suggestions
    let xhr;
    $el.keyup(function () {
        if (xhr) {
            xhr.abort();
        }

        const prefix = $el.val();
        if (prefix) {
            $suggestions.empty();
            $suggestions.append('<li>Loading...</li>');
            // get suggestions
            xhr = $.get('/map/api/suggestion/search', { prefix, field }, function (suggestions) {
                // remove previous suggestions
                $suggestions.empty();
                // add each suggestion as a <li>
                suggestions.forEach(suggestion => {
                    const $suggestion = $(`<li role="button">${suggestion}</li>`);
                    $suggestions.append($suggestion);

                    // when the item is clicked, add it to the selected items
                    // and then clear the suggestions list and the input
                    $suggestion.click(function () {
                        _addToSelected(suggestion, $selected, $hidden);
                        $suggestions.empty();
                        $el.val('');
                    });
                });
                // add a special "Add tag" option if the prefix doesn't exist in the suggestions
                if (suggestions.indexOf(prefix) === -1) {
                    const $add = $(`<li role="button">Add tag: "${prefix}"</li>`);
                    $suggestions.append($add);
                    $add.click(function () {
                        _addToSelected(prefix, $selected, $hidden);
                        $suggestions.empty();
                        $el.val('');
                    });
                }
            });
        } else {
            // if the current item is the empty string, remove the suggestions
            $suggestions.empty();
        }

        return false;
    })
}

/**
 * Add the item to the $selected list and to the value of the $hidden field
 *
 * @param item
 * @param $selected
 * @param $hidden
 * @private
 */
function _addToSelected(item, $selected, $hidden) {
    const $item = $(`<li><span>${item}</span></li>`);
    const $delete = $('<button title="delete" class="fa fa-times btn btn-default"></button>');
    $delete.click(function (e) {
        e.preventDefault();
        _removeSelectedItem(item, $item, $hidden);
        return false;
    });
    $item.append($delete);
    $selected.append($item);
    const currentItems = _stringToArray($hidden.val());
    currentItems.push(item);
    $hidden.val(currentItems.join(','));
}

/**
 * Undo _addToSelected. Requires the item and the $item jquery element that was created
 * when _addToSelected was called.
 *
 * @param item
 * @param $item
 * @param $hidden
 * @private
 */
function _removeSelectedItem(item, $item, $hidden) {
    const selectedItems = _stringToArray($hidden.val());
    const index = selectedItems.indexOf(item);
    selectedItems.splice(index, 1);
    $hidden.val(selectedItems.join(','));
    $item.remove();
}

function _stringToArray(val) {
    return val.split(',').map(item => item.trim()).filter(Boolean);
}

module.exports = combobox;
