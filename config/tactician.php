<?php

use TheRestartProject\RepairDirectory\Application\Auth\DeleteFixometerSessionCommand;
use TheRestartProject\RepairDirectory\Application\Auth\DeleteFixometerSessionHandler;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionCommand;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionHandler;
use TheRestartProject\RepairDirectory\Application\CommandBus\Middleware\TransactionMiddleware;
use \TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow;
use TheRestartProject\RepairDirectory\Application\Commands\Business\DeleteBusiness;
use \TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;


return [

    'handlers' => [
        ImportFromCsvRow\ImportFromCsvRowCommand::class => ImportFromCsvRow\ImportFromCsvRowHandler::class,
        ImportFromHttpRequest\ImportFromHttpRequestCommand::class => ImportFromHttpRequest\ImportFromHttpRequestHandler::class,
        UpdateFixometerSessionCommand::class => UpdateFixometerSessionHandler::class,
        DeleteFixometerSessionCommand::class => DeleteFixometerSessionHandler::class,
        DeleteBusiness\DeleteBusinessCommand::class => DeleteBusiness\DeleteBusinessHandler::class
    ],

    'middleware' => [
        \League\Tactician\Logger\LoggerMiddleware::class,
        \TheRestartProject\RepairDirectory\Tactician\Validator\CommandValidatorMiddleware::class,
        \TheRestartProject\RepairDirectory\Tactician\Authorizer\CommandAuthorizerMiddleware::class,
        TransactionMiddleware::class,
        \League\Tactician\Handler\CommandHandlerMiddleware::class
    ],

    'validators' => [
        ImportFromHttpRequest\ImportFromHttpRequestCommand::class => ImportFromHttpRequest\ImportFromHttpRequestValidator::class,
    ],

    'authorizers' => [
        ImportFromHttpRequest\ImportFromHttpRequestCommand::class => ImportFromHttpRequest\ImportFromHttpRequestAuthorizer::class,
    ]
];