<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;

/**
 * Command to create or update a business from HTTP post data
 *
 * @category Command
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromHttpRequestCommand
{
    /**
     * The HTTP request data to import as a Business
     *
     * @var array
     */
    private $data;
    private $businessUid;

    /**
     * Creates the ImportFromHttpRequestCommand from a CSV Row
     *
     * @param array   $data        The HTTP request data to import as a Business
     * @param integer $businessUid The id of the business to update
     */
    public function __construct($data, $businessUid = null)
    {
        $this->data = $data;
        $this->businessUid = $businessUid;
    }

    /**
     * Gets the data from the Command
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return the uid of the business to update (if any)
     *
     * @return integer|null
     */
    public function getBusinessUid()
    {
        return $this->businessUid;
    }

}
