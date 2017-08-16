<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;

/**
 * Class CategoryValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ReviewSourceValidator implements Validator
{

    /**
     * Throw an exception if the provided string isn't present in the ReviewSource enum
     *
     * @param string $source The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    function validate($source)
    {
        $foundSource = ReviewSource::search($source);
        if (!$foundSource) {
            throw new ValidationException('Category invalid: unknown category');
        }
    }

}



