<?php

namespace TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions;

use Psr\Container\ContainerExceptionInterface;

/**
 * Implementation of the ContainerExceptionInterface
 *
 * This exception implements the ContainerExceptionInterface, part of the ContainerInterface
 * functionality
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ContainerException extends \Exception implements ContainerExceptionInterface
{

}