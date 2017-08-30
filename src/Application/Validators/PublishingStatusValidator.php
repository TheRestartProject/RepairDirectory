<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Validation\Validators\Validator;

/**
 * Class PublishingStatusValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Paul Fauth-Mayer <paul@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class PublishingStatusValidator implements Validator
{

    /**
     * Throw an exception if the provided string isn't present in the PublishingStatus enum
     *
     * @param string $status The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function validate($status)
    {
        $foundStatus = PublishingStatus::search($status);
        if (!$foundStatus) {
            throw new ValidationException('Category invalid: unknown category');
        }
    }

}



