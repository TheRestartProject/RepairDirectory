<?php

namespace TheRestartProject\RepairDirectory\Tactician\Security\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Class
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class CanNotInvokeSecurityException extends \BadMethodCallException implements Exception
{

    /**
     * @var mixed
     */
    private $command;

    /**
     * @param mixed $command
     * @param string $reason
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