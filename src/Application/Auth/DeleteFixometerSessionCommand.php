<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use TheRestartProject\RepairDirectory\Application\CommandBus\Middleware\NonDefaultConnectionCommand;

/**
 * Class DeleteFixometerSessionCommand
 *
 * @category Command
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://outlandish.com
 */
class DeleteFixometerSessionCommand implements NonDefaultConnectionCommand
{
    /**
     * The unique id of the session
     *
     * @var int
     */
    private $sessionId;

    /**
     * DeleteFixometerSessionCommand constructor.
     *
     * @param int $sessionId The id of the session to delete
     */
    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Gets the session Id
     *
     * @return int
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Returns the Doctrine connection to use for the TransactionMiddleware
     *
     * @return string
     */
    public function getConnectionName()
    {
        return 'fixometer';
    }
}