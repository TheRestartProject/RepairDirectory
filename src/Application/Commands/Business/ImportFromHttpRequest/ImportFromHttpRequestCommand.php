<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;

use Illuminate\Http\Request;

/**
 * Command to create a business from HTTP post data
 *
 * @category Command
 * @package  TheRestartProject\RepairDirectory\Application\Business\Commands
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromHttpRequestCommand
{
    /**
     * The HTTP request to import as a Business
     *
     * @var Request
     */
    private $request;
    private $businessUid;

    /**
     * Creates the ImportFromHttpRequestCommand from a CSV Row
     *
     * @param Request $request The HTTP request to import as a Business
     * @param integer $businessUid The id of the business to update
     */
    public function __construct($request, $businessUid = null)
    {
        $this->request = $request;
        $this->businessUid = $businessUid;
    }

    /**
     * Gets the request from the Command
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return integer
     */
    public function getBusinessUid()
    {
        return $this->businessUid;
    }

}
