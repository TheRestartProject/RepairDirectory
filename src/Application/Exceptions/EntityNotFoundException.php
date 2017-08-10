<?php

namespace TheRestartProject\RepairDirectory\Application\Exceptions;

/**
 * Class EntityNotFoundException
 *
 * @category Exception
 * @package  TheRestartProject\RepairDirectory\Domain\Exceptions
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class EntityNotFoundException extends \Exception
{
    protected $message = 'Entity not found';
    protected $code = 404;
}
