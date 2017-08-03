<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow;

/**
 * Command to import business from csv row
 *
 * @category Command
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromCsvRowCommand
{
    /**
     * The CSV Row to imported as a business
     *
     * @var array
     */
    private $row;

    /**
     * Creates the ImportBusinessFromCsvRowCommand from a CSV Row
     *
     * @param array $row The CSV row to import as a Business
     */
    public function __construct(array $row)
    {
        $this->row = $row;
    }

    /**
     * Gets the CSV Row from the Command
     *
     * @return array
     */
    public function getRow()
    {
        return $this->row;
    }
}
