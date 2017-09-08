<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Inflectors;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Inflectors\MethodNameInflector;

/**
 * Determines how to call the authorizer
 *
 * @category Inflector
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class AuthorizeInflector implements MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command           The command to be authorized
     * @param object $commandAuthorizer The authorizer to run
     *
     * @return string
     */
    public function inflect($command, $commandAuthorizer)
    {
        return 'authorize';
    }
}
