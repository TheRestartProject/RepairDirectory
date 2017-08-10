<?php

namespace TheRestartProject\RepairDirectory\Application\Exceptions;
use Exception;

/**
 * Class ValidationException
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Domain\Exceptions
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ValidationException extends Exception
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
        $message = implode(', ', array_values($errors));
        parent::__construct($message);
    }
    
    public function getErrors() {
        return $this->errors;
    }
}
