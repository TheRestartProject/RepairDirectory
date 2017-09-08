<?php

namespace TheRestartProject\RepairDirectory\Domain\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Validates a business
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Domain\Validators
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface BusinessValidator
{

    /**
     * Throw a BusinessValidationException if the provided business has any invalid fields.
     *
     * @param array $business The business to validate
     *
     * @return void
     *
     * @throws BusinessValidationException Thrown if the business is invalid
     */
    public function validate($business);

    /**
     * Run the validator for a specific field
     *
     * @param string $field The name of the Business field to validate
     * @param mixed  $value The value to validate
     *
     * @throws ValidationException
     *
     * @return void
     */
    public function validateField($field, $value);
}
