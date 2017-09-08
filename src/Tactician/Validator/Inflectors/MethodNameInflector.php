<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Inflectors;

/**
 * Determines how the validator will be called
 *
 * @category Inflector
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Inflectors
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command        The command to validate
     * @param object $commandHandler The validator to run the command with
     *
     * @return string
     */
    public function inflect($command, $commandHandler);
}
