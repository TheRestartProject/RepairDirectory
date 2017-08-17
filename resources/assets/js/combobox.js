const $ = require('jquery');

/**
 * Convert a text input into a combobox, where items are of type `field`
 *
 * @param $el
 * @param field
 */
function combobox ($el, field) {
    const initialItems = $el.val().split(',');

    // the combobox gives suggestions for the last item in the comma-separated list
    let activeItem = initialItems[ initialItems.length - 1 ].trim();

    // create the element where suggestions will be shown, and add it to the parent element
    const $results = $('<ul class="combobox__results"></ul>');
    $el.parent().append($results);

    // clear the results when the element loses focus
    $el.blur(function () {
        // setTimeout to allow list items to be clicked
        setTimeout(() => $results.empty(), 300);
    });

    // prevent form submit when enter is pressed
    $el.keydown(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            return false;
        }
    });

    // when a key is released, query the API for suggestions
    $el.keyup(function () {
        const items = $el.val().split(',');
        const lastItem = items[ items.length - 1 ].trim();

        // the user isn't changing the last item in the list so we don't know which item to get suggestions for
        if (lastItem === activeItem) {
            return;
        }

        activeItem = lastItem;

        // get the last item in the comma-separated list
        if (activeItem) {
            // get suggestions for the last item
            $.get('/map/api/suggestion/search', { prefix: activeItem, field }, function (suggestions) {
                // remove previous suggestions
                $results.empty();
                // add each suggestion as an <li>
                suggestions.forEach((suggestion) => {
                    const $suggestion = $(`<li role="button">${suggestion}</li>`);
                    // when the item is clicked, replace the last element in the comma separated list with the item's value
                    // and then clear the suggestions list
                    $suggestion.click(function () {
                        const currentItems = $el.val().split(',').map(item => item.trim());
                        currentItems.pop();
                        currentItems.push(suggestion);
                        $el.val(currentItems.join(', '));
                        $results.empty();
                    });

                    $results.append($suggestion);
                });
            });
        } else {
            // if the current item is the empty string, remove the suggestions
            $results.empty();
        }

        return false;
    })
}

module.exports = combobox;
