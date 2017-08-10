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
    /**
     * The reasons the business is invalid, keyed by field name
     *
     * @var array
     */
    private $errors;

    /**
     * The invalid business
     *
     * @var Business
     */
    private $business;

    /**
     * BusinessValidationException constructor.
     *
     * @param Business $business The business with errors
     * @param array    $errors   The errors explaining why the business is invalid, keyed by field name
     */
    public function __construct($business, $errors)
    {
        $this->business = $business;
        $this->errors = $errors;
        $message = implode(', ', array_values($errors));
        parent::__construct($message);
    }

    /**
     * Return the reasons the business is invalid
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Return the invalid business
     *
     * @return Business
     */
    public function getBusiness()
    {
        return $this->business;
    }
}
