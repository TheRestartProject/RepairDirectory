<?php

use \TheRestartProject\RepairDirectory\Application\Business\Commands as BusinessCommands;
use \TheRestartProject\RepairDirectory\Application\Business\Handlers as BusinessHandlers;

return [
    'handlers' => [
        BusinessCommands\ImportBusinessFromCsvRowCommand::class => BusinessHandlers\ImportBusinessFromCsvRowHandler::class
    ],
    'middleware' => [
        \League\Tactician\Logger\LoggerMiddleware::class,
        \League\Tactician\Doctrine\ORM\TransactionMiddleware::class,
        \League\Tactician\Handler\CommandHandlerMiddleware::class
    ]
];