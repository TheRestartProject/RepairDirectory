<?php
/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 26/07/2017
 * Time: 16:38
 */

namespace TheRestartProject\RepairDirectory\Infrastructure\ModelFactories;


use TheRestartProject\RepairDirectory\Domain\Models\Business;

class BusinessFactory
{
    /**
     * Creates a Business from a CSV row that has been parsed into an associative array.
     * The keys of the array are the CSV column headers.
     * 
     * @param $row
     * @return Business
     */
    public static function fromCsvRow($row)
    {
        $business = new Business();
        $business->setName($row['Name']);
        $business->setAddress($row['Address']);
        $business->setPostcode($row['Postcode']);
        return $business;
    }
}