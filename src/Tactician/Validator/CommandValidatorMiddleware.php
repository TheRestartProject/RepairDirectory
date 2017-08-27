<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator;

use League\Tactician\Middleware;
use TheRestartProject\RepairDirectory\Tactician\Validator\Exceptions\CanNotInvokeValidatorException;
use TheRestartProject\RepairDirectory\Tactician\Validator\Extractors\CommandNameExtractor;
use TheRestartProject\RepairDirectory\Tactician\Validator\Inflectors\MethodNameInflector;
use TheRestartProject\RepairDirectory\Tactician\Validator\Locators\ValidatorLocator;

/**
 * Class CommandValidatorMiddleware
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class CommandValidatorMiddleware implements Middleware
{
    /**
     * @var CommandNameExtractor
     */
    private $commandNameExtractor;

    /**
     * @var ValidatorLocator
     */
    private $validatorLocator;

    /**
     * @var MethodNameInflector
     */
    private $methodNameInflector;

    /**
     * @param CommandNameExtractor $commandNameExtractor
     * @param ValidatorLocator     $validatorLocator
     * @param MethodNameInflector  $methodNameInflector
     */
    public function __construct(
        CommandNameExtractor $commandNameExtractor,
        ValidatorLocator $validatorLocator,
        MethodNameInflector $methodNameInflector
    ) {
        $this->commandNameExtractor = $commandNameExtractor;
        $this->validatorLocator = $validatorLocator;
        $this->methodNameInflector = $methodNameInflector;
    }

    /**
     * Executes a command and optionally returns a value
     *
     * @param object   $command
     * @param callable $next
     *
     * @return mixed
     *
     * @throws CanNotInvokeHandlerException
     */
    public function execute($command, callable $next)
    {
        $commandName = $this->commandNameExtractor->extract($command);
        $validator = $this->validatorLocator->getValidatorForCommand($commandName);
        $methodName = $this->methodNameInflector->inflect($command, $validator);

        // is_callable is used here instead of method_exists, as method_exists
        // will fail when given a handler that relies on __call.
        if (!is_callable([$validator, $methodName])) {
            throw CanNotInvokeValidatorException::forCommand(
                $command,
                "Method '{$methodName}' does not exist on handler"
            );
        }

        $validator->{$methodName}($command);

        return $next($command);
    }
}