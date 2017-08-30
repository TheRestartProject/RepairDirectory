<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class PostcodeValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class PostcodeValidator implements Validator
{

    /**
     * Throw a ValidationException if the postcode is too short, too long, or does not include a space
     *
     * @param string $postcode The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate($postcode)
    {
        if (strpos($postcode, " ") === false) {
            throw new ValidationException('Postcode invalid: must include a space');
        }
        if (strlen($postcode) < 7) {
            throw new ValidationException('Postcode invalid: too short');
        }
        if (strlen($postcode) > 8) {
            throw new ValidationException('Postcode invalid: too long');
        }
    }

}
