<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class NumberRangeValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Paul Fauth-Mayer <paul@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class NumberRangeValidator implements Validator
{

    private $min;
    private $max;
    private $decimalValuesAllowed;
    private $fieldNameTitleCase;

    /**
     * StringLengthValidator constructor.
     *
     * @param string  $fieldNameTitleCase   A readable label for the value being tested. Used to form the error message
     * @param integer $min                  The minimum value of valid numbers
     * @param integer $max                  The maximum value of valid numbers
     * @param boolean $decimalValuesAllowed True if non-integers are valid
     */
    function __construct($fieldNameTitleCase, $min, $max, $decimalValuesAllowed)
    {
        $this->min = $min;
        $this->max = $max;
        $this->fieldNameTitleCase = $fieldNameTitleCase;
        $this->decimalValuesAllowed = $decimalValuesAllowed;
    }



    /**
     * Throws a validation exception if the string is shorter than $this->min or longer than $this->max.
     *
     * @param string $value The value to test
     *
     * @return void
     *
     * @throws ValidationException
     */
    function validate($value)
    {

        if (!is_numeric($value)) {
            throw new ValidationException($this->fieldNameTitleCase . " invalid: must be a number!");
        }
        if (!$this->decimalValuesAllowed && !ctype_digit($value)) {
            var_dump("fail!");
            throw new ValidationException($this->fieldNameTitleCase . " invalid: must not be a decimal number!");
        }
        if ($value < $this->min || $value > $this->max) {
            throw new ValidationException($this->fieldNameTitleCase . " invalid: must be between $this->min and $this->max ");
        }
    }

}
