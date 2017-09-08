<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Thrown when the authorizer cannot be found
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class MissingAuthorizerException extends \OutOfBoundsException implements Exception
{
    /**
     * The name of the command
     *
     * @var string
     */
    private $commandName;

    /**
     * Creates the exception for a given command name
     *
     * @param string $commandName The name of the command the exception is for
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
     * Get the command name
     *
     * @return string
     */
    public function getCommandName()
    {
        return $this->commandName;
    }
}
