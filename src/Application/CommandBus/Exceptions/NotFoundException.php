<?php

namespace TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Implementation of the NotFoundExceptionInterface
 *
 * This exception implements the NotFoundExceptionInterface, part of the ContainerInterface
 * functionality
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{

}
