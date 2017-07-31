<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\ModelFactories;

use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Class BusinessFactory
 *
 * @category Factory
 * @package  TheRestartProject\RepairDirectory\Infrastructure\ModelFactories
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class BusinessFactory
{
    /**
     * Creates a Business from a CSV row that has been parsed
     * into an associative array.
     *
     * The keys of the array are the CSV column headers.
     * 
     * @param array $row An associative array containing the row data
     * 
     * @return Business
     */
    public function fromCsvRow($row)
    {
        $business = new Business();
        $business->setName($row['Name']);
        $business->setAddress($row['Address']);
        $business->setPostcode($row['Postcode']);
        return $business;
    }
}
