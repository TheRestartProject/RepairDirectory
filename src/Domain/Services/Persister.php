<?php
/**
 * Created by PhpStorm.
 * User: Joaquim
 * Date: 26/07/2017
 * Time: 21:07
 */

namespace TheRestartProject\RepairDirectory\Domain\Services;


interface Persister
{
    public function commit();
}