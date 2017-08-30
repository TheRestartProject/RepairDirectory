<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Inflectors;

/**
 * Determines what method to call to invoke the validator
 *
 * @category Inflector
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class ValidateInflector implements MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command        The command to validate
     * @param object $commandHandler The validator to run the command on
     *
     * @return string
     */
    public function inflect($command, $commandHandler)
    {
        return 'validate';
    }
}