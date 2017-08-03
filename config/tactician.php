<?php

use \TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow;
use \TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;


return [
    'handlers' => [
        ImportFromCsvRow\ImportFromCsvRowCommand::class => ImportFromCsvRow\ImportFromCsvRowHandler::class,
        ImportFromHttpRequest\ImportFromHttpRequestCommand::class => ImportFromHttpRequest\ImportFromHttpRequestHandler::class
    ],
    'middleware' => [
        \League\Tactician\Logger\LoggerMiddleware::class,
        \League\Tactician\Doctrine\ORM\TransactionMiddleware::class,
        \League\Tactician\Handler\CommandHandlerMiddleware::class
    ]
];