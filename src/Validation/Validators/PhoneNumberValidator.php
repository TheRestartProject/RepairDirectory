<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class PhoneNumberValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class PhoneNumberValidator implements Validator
{

    private $fieldNameTitleCase;

    /**
     * PhoneNumberValidator constructor.
     *
     * @param string $fieldNameTitleCase A readable label for the value being tested. Used to form the error message
     */
    public function __construct($fieldNameTitleCase)
    {
        $this->fieldNameTitleCase = $fieldNameTitleCase;
    }

    /**
     * Throw a ValidationException if the phone number is too short, too long, or not numeric (not including
     * spaces).
     *
     * @param string $number The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate($number)
    {
        $chars = str_split($number);
        foreach ($chars as $char) {
            if ($char !== ' ' && !is_numeric($char)) {
                throw new ValidationException("$this->fieldNameTitleCase invalid: only numbers allowed");
            }
        }
        if (strlen($number) < 10 || strlen($number) > 20) {
            throw new ValidationException("$this->fieldNameTitleCase invalid: must be between 10 and 20 numbers long");
        }
    }
}
