<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

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



class BooleanValidator implements Validator
{

    /**
     * Throws a validation exception if the value is not a boolean value
     *
     * @param string $value The value to test
     *
     * @return void
     *
     * @throws ValidationException
     */

    function validate($value)
    {
        if( !is_bool($value)){
            throw new ValidationException("Warranty Offered invalid: must be either true or false!");
        }
    }

}

