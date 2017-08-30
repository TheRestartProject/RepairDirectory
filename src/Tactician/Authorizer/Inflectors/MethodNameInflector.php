<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Inflectors;

/**
 * Determines how the authorizer will be called
 *
 * @category Inflector
 * @package  TheRestartProject\RepairDirectory\Tactician\Authorizer\Inflectors
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command           The command to invoke
     * @param object $commandAuthorizer The authorizer for this command
     *
     * @return string
     */
    public function inflect($command, $commandAuthorizer);
}