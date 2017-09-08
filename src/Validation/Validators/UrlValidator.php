<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class UrlValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class UrlValidator implements Validator
{

    private $errorMessage;

    /**
     * StringLengthValidator constructor.
     *
     * @param string $fieldNameTitleCase A readable label for the value being tested. Used to form the error message
     */
    public function __construct($fieldNameTitleCase)
    {
        $this->errorMessage = $fieldNameTitleCase . " invalid";
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
        // allow missing protocol
        $url = strpos($value, 'http') === 0 ? $value : 'http://' . $value;
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new ValidationException($this->errorMessage);
        }
        // check TLD exists
        $parts = explode('.', $url);
        if (count($parts) < 2) {
            throw new ValidationException($this->errorMessage);
        }
        if (strlen($parts[1]) < 1) {
            throw new ValidationException($this->errorMessage);
        }
    }

}
