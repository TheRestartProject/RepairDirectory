<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;

/**
 * Class CategoryValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class CategoryValidator implements Validator
{
    /**
     * Throw an exception if the provided string isn't present in the Category enum
     *
     * @param string $category The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    function validate($category)
    {
        $foundCategory = Category::search($category);
        if (!$foundCategory) {
            throw new ValidationException('Category invalid: unknown category');
        }
    }

}
