<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Locators;

use TheRestartProject\RepairDirectory\Tactician\Validator\MissingHandlerException;

/**
 * Class SecurityLocator
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
interface AuthorizerLocator
{
    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getAuthorizerForCommand($commandName);
}