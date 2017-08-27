<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Class MissingAuthorizerException
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class MissingAuthorizerException extends \OutOfBoundsException implements Exception
{
    /**
     * @var string
     */
    private $commandName;

    /**
     * @param string $commandName
     *
     * @return static
     */
    public static function forCommand($commandName)
    {
        $exception = new static('Missing security for command ' . $commandName);
        $exception->commandName = $commandName;

        return $exception;
    }

    /**
     * @return string
     */
    public function getCommandName()
    {
        return $this->commandName;
    }
}