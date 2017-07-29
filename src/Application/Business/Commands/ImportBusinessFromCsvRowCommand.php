<?php

namespace TheRestartProject\RepairDirectory\Application\Business\Commands;

/**
 * Command to import business from csv row
 *
 * @package TheRestartProject\RepairDirectory\Application\Business\Commands
 * @author Matthew Kendon <matt@outlandish.com>
 */
class ImportBusinessFromCsvRowCommand
{
    /**
     * @var array
     */
    private $row;

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function getRow()
    {
        return $this->row;
    }
}