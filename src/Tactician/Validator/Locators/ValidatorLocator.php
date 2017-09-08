<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Locators;

use TheRestartProject\RepairDirectory\Tactician\Validator\MissingHandlerException;

/**
 * Locates the validator to validate the command with
 *
 * @category Locator
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface ValidatorLocator
{
    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName The name of the command
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getValidatorForCommand($commandName);
}
