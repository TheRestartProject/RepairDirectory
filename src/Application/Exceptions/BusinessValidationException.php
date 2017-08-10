<?php

namespace TheRestartProject\RepairDirectory\Application\Exceptions;
use Exception;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Class BusinessValidationException
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Domain\Exceptions
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class BusinessValidationException extends Exception
{
    /** @var array */
    private $errors;

    /** @var Business */
    private $business;

    /**
     * BusinessValidationException constructor.
     * @param string $business
     * @param array $errors
     */
    public function __construct($business, $errors)
    {
        $this->business = $business;
        $this->errors = $errors;
        $message = implode(', ', array_values($errors));
        parent::__construct($message);
    }
    
    public function getErrors() {
        return $this->errors;
    }

    /**
     * @return Business
     */
    public function getBusiness()
    {
        return $this->business;
    }
}
