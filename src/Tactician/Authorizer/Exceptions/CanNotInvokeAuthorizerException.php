<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Thrown when the authorizer cannot be invoked
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class CanNotInvokeAuthorizerException extends \BadMethodCallException implements Exception
{

    /**
     * The command that caused the issue
     *
     * @var mixed
     */
    private $command;

    /**
     * Constructs the exception for a given command
     *
     * @param mixed  $command The command the exception is for
     * @param string $reason  The reason for the exception
     *
     * @return static
     */
    public static function forCommand($command, $reason)
    {
        $type =  is_object($command) ? get_class($command) : gettype($command);

        $exception = new static(
            'Could not invoke security for command ' . $type .
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