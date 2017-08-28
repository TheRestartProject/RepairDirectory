<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions;

use League\Tactician\Exception\Exception;

/**
 * Thrown when the command name cannot be determined
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class CanNotDetermineCommandNameException extends \RuntimeException implements Exception
{

}