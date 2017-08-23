<?php

namespace TheRestartProject\RepairDirectory\Application\CommandBus\Middleware;


/**
 * Allows the transaction middleware to determine the connection
 *
 * @category Middleware
 * @package  TheRestartProject\RepairDirectory\Application\CommandBus\Middleware
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface NonDefaultConnectionCommand
{
    /**
     * Returns the Doctrine connection to use for the TransactionMiddleware
     *
     * @return string
     */
    public function getConnectionName();
}
