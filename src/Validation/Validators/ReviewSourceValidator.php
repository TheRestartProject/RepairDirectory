<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;

/**
 * Class ReviewSourceValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Paul Fauth-Mayer <paul@outlandish.com>
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
    public function validate($source)
    {
        $foundSource = ReviewSource::search($source);
        if (!$foundSource) {
            throw new ValidationException('Category invalid: unknown category');
        }
    }

}



