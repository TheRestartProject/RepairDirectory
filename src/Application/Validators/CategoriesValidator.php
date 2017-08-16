<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;

/**
 * Class CategoriesValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class CategoriesValidator implements Validator
{
    /**
     * Throw an exception if any item in the provided array isn't present in the Category enum
     *
     * @param array $categories The values to validate
     *
     * @return void
     *
     * @throws ValidationException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    function validate($categories)
    {
        foreach($categories as $category) {
            $foundCategory = Category::search($category);
            if (!$foundCategory) {
                throw new ValidationException('Category invalid: unknown category');
            }
        }
    }

}
