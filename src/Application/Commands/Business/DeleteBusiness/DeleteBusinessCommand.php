<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\DeleteBusiness;

use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Command to delete a business by id
 *
 * @category Command
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class DeleteBusinessCommand
{
    private $business;

    /**
     * Return the Business to be deleted
     *
     * @return Business
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * DeleteBusinessCommand constructor.
     *
     * @param Business $business The business to be deleted
     */
    public function __construct($business)
    {
        $this->business = $business;
    }
}
