<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Thrown when the validator cannot be invoked
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class CanNotInvokeValidatorException extends \BadMethodCallException implements Exception
{

    /**
     * The command that was to be validated
     *
     * @var mixed
     */
    private $command;

    /**
     * Creates the exception for a given command
     *
     * @param mixed  $command The command that caused the exception
     * @param string $reason  The reason for the exception
     *
     * @return static
     */
    public static function forCommand($command, $reason)
    {
        $type =  is_object($command) ? get_class($command) : gettype($command);

        $exception = new static(
            'Could not invoke validator for command ' . $type .
            ' for reason: ' . $reason
        );
        $exception->command = $command;

        return $exception;
    }

    /**
     * Returns the command that could not be invoked
     *
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }
}
