<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\DeleteBusiness;

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
    private $uid;
    
    public function getUid()
    {
        return $this->uid;
    }
    
    public function __construct($uid)
    {
        $this->uid = $uid;
    }
}
