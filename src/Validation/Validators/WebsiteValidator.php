<?php

namespace TheRestartProject\RepairDirectory\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;

/**
 * Class WebsiteValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class WebsiteValidator implements Validator
{

    /**
     * Throw a ValidationException if the website is too short, too long, or doesn't include a '.'
     *
     * @param string $website The value to validate
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function validate($website)
    {
        if (strlen($website) < 5 || strlen($website) > 100) {
            throw new ValidationException('Website invalid: must be between 5 and 100 characters long');
        }
        if (strpos($website, '.') === false) {
            throw new ValidationException('Website invalid: must include a domain');
        }
    }

}
