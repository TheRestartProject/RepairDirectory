<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Exception thrown if a validator has not been found
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class MissingValidatorException extends \OutOfBoundsException implements Exception
{
    /**
     * The name of the command
     *
     * @var string
     */
    private $commandName;

    /**
     * Constructs the exception for a command
     *
     * @param string $commandName The name of the command
     *
     * @return static
     */
    public static function forCommand($commandName)
    {
        $exception = new static('Missing validator for command ' . $commandName);
        $exception->commandName = $commandName;

        return $exception;
    }

    /**
     * Get the command name
     *
     * @return string
     */
    public function getCommandName()
    {
        return $this->commandName;
    }
}