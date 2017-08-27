<?php

namespace TheRestartProject\RepairDirectory\Tactician\Security\Inflectors;

/**
 * Class AuthorizeInflector
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class AuthorizeInflector implements MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command
     * @param object $commandAuthorizer
     *
     * @return string
     */
    public function inflect($command, $commandAuthorizer)
    {
        return 'authorize';
    }
}