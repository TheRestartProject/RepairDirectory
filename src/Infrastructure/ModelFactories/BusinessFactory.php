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
    public static function fromRow($row) {
        $business = new Business();
        $business->setName($row['Name']);
        $business->setAddress($row['Address']);
        $business->setPostcode($row['Postcode']);
        return $business;
    }
}