<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;


/**
 * Class UpdateFixometerSessionCommand
 * @category Command
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class UpdateFixometerSessionCommand
{
    /**
     * The token for the session
     *
     * @var string
     */
    private $token;

    /**
     * The user id to add to the session
     *
     * @var integer
     */
    private $userId;

    /**
     * Constructs UpdateFixometerSessionCommand constructor.
     *
     * @param string  $token  The token for the session
     * @param integer $userId The user id to be added to the session
     */
    public function __construct($token, $userId)
    {
        $this->token = $token;
        $this->userId = $userId;
    }

    /**
     * Gets the token to update the session for
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Gets the user id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

}