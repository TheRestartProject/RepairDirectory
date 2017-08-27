<?php

namespace TheRestartProject\RepairDirectory\Tactician\Security\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Class MissingValidatorException
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class MissingSecurityException extends \OutOfBoundsException implements Exception
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