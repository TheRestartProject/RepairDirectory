<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 11:15
 */

namespace TheRestartProject\RepairDirectory\Domain\Repositories;


use TheRestartProject\RepairDirectory\Domain\Models\Business;

interface BusinessRepository
{

    public function add(Business $business);
    
    public function persist();

}
