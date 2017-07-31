<?php

use \TheRestartProject\RepairDirectory\Application\Business\Commands as BusinessCommands;
use \TheRestartProject\RepairDirectory\Application\Business\CommandHandlers as BusinessHandlers;

return [
    'handlers' => [
        BusinessCommands\ImportFromCsvRowCommand::class => BusinessHandlers\ImportFromCsvRowHandler::class
    ],
    'middleware' => [
        \League\Tactician\Logger\LoggerMiddleware::class,
        \League\Tactician\Doctrine\ORM\TransactionMiddleware::class,
        \League\Tactician\Handler\CommandHandlerMiddleware::class
    ]
];