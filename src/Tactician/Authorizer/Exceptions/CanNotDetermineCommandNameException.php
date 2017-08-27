<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Class CannotDetermineCommandNameException
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class CanNotDetermineCommandNameException extends \RuntimeException implements Exception
{

}