<?php

use TheRestartProject\RepairDirectory\Application\Auth\DeleteFixometerSessionCommand;
use TheRestartProject\RepairDirectory\Application\Auth\DeleteFixometerSessionHandler;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionCommand;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionHandler;
use TheRestartProject\RepairDirectory\Application\CommandBus\Middleware\TransactionMiddleware;
use \TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow;
use \TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;
use \TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion;


return [
    'handlers' => [
        ImportFromCsvRow\ImportFromCsvRowCommand::class => ImportFromCsvRow\ImportFromCsvRowHandler::class,
        ImportFromHttpRequest\ImportFromHttpRequestCommand::class => ImportFromHttpRequest\ImportFromHttpRequestHandler::class,
        AddSuggestion\AddSuggestionCommand::class => AddSuggestion\AddSuggestionHandler::class,
        UpdateFixometerSessionCommand::class => UpdateFixometerSessionHandler::class,
        DeleteFixometerSessionCommand::class => DeleteFixometerSessionHandler::class
    ],
    'middleware' => [
        \League\Tactician\Logger\LoggerMiddleware::class,
        TransactionMiddleware::class,
        \League\Tactician\Handler\CommandHandlerMiddleware::class
    ]
];