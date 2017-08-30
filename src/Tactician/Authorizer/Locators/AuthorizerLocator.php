<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Locators;

use TheRestartProject\RepairDirectory\Tactician\Validator\MissingHandlerException;

/**
 * Locates the authorizer for a command
 *
 * @category Locator
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface AuthorizerLocator
{
    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName The name of the command to authorize
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getAuthorizerForCommand($commandName);
}