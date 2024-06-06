<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class ReviewMailOptoutValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Graham Lally <graham@groundlake.org>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ReviewMailOptoutValidator implements Validator
{

    /**
     * Throws a validation exception if the value is not a boolean value
     *
     * @param mixed $value The value to test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate($value)
    {
        if (!is_bool($value)) {
            throw new ValidationException("Email review setting invalid: must be either true or false!");
        }
    }

}

