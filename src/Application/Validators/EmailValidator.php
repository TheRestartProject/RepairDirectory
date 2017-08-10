<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class EmailValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class EmailValidator implements Validator
{

    /**
     * Throw a ValidationException if the email is too short, too long, or doesn't include an '@' and a '.'
     *
     * @param string $email The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     */
    function validate($email)
    {
        if (strlen($email) < 6 || strlen($email) > 100) {
            throw new ValidationException('Email invalid: must be between 6 and 100 characters long');
        }
        if (strpos($email, "@") === false || strpos($email, '.') === false) {
            throw new ValidationException('Email invalid: must include a domain');
        }
    }

}
