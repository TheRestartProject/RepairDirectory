<?php

namespace TheRestartProject\RepairDirectory\Application\CommandBus\Middleware;

/**
 * Interface NonDefaultConnectionCommand
 * @package TheRestartProject\RepairMap\Application\CommandBus\Middleware
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
