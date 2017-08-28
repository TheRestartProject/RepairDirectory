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
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class CommandValidatorMiddleware implements Middleware
{
    /**
     * The object to extract the name of the command with
     *
     * @var CommandNameExtractor
     */
    private $commandNameExtractor;

    /**
     * The object to locate the validator with
     *
     * @var ValidatorLocator
     */
    private $validatorLocator;

    /**
     * The object to determine how to call the validator
     *
     * @var MethodNameInflector
     */
    private $methodNameInflector;

    /**
     * Constructs the middleware
     *
     * @param CommandNameExtractor $commandNameExtractor The command name extractor
     * @param ValidatorLocator     $validatorLocator     The validator locator
     * @param MethodNameInflector  $methodNameInflector  The method name inflector
     *
     * @return self
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
     * @param object   $command The command to validate
     * @param callable $next    The next middleware in the chain
     *
     * @return mixed
     *
     * @throws CanNotInvokeHandlerException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
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