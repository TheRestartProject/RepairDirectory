<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class StringLengthValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class StringLengthValidator implements Validator
{

    private $min;
    private $max;
    private $errorMessage;

    /**
     * StringLengthValidator constructor.
     *
     * @param string  $fieldNameTitleCase A readable label for the value being tested. Used to form the error message
     * @param integer $min                The minimum length of valid strings
     * @param integer $max                The maximum length of valid strings
     */
    public function __construct($fieldNameTitleCase, $min, $max)
    {
        $this->min = $min;
        $this->max = $max;
        $this->errorMessage = $fieldNameTitleCase . " invalid: must be between $this->min and $this->max characters long";
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
    public function validate($value)
    {
        if (strlen($value) < $this->min || strlen($value) > $this->max) {
            throw new ValidationException($this->errorMessage);
        }
    }

}
