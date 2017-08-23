<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;


/**
 * Class DeleteFixometerSessionCommand
 * @category
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class DeleteFixometerSessionCommand
{
    /**
     * @var int
     */
    private $sessionId;

    /**
     * DeleteFixometerSessionCommand constructor.
     * @param int $sessionId
     */
    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return int
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
}