<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Locators;

use TheRestartProject\RepairDirectory\Tactician\Validator\MissingHandlerException;

/**
 * Class ValidatorLocator
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
interface ValidatorLocator
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
    public function getValidatorForCommand($commandName);
}