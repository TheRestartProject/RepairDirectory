<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Inflectors;

/**
 * Class ValidateInflector
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class ValidateInflector implements MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command
     * @param object $commandHandler
     *
     * @return string
     */
    public function inflect($command, $commandHandler)
    {
        return 'validate';
    }
}