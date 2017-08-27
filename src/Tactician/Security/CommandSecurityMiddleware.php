<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator;

use League\Tactician\Middleware;
use TheRestartProject\RepairDirectory\Tactician\Security\Exceptions\CanNotInvokeValidatorException;
use TheRestartProject\RepairDirectory\Tactician\Security\Extractors\CommandNameExtractor;
use TheRestartProject\RepairDirectory\Tactician\Security\Inflectors\MethodNameInflector;
use TheRestartProject\RepairDirectory\Tactician\Security\Locators\SecurityLocator;

/**
 * Class CommandSecurityMiddleware
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Security
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class CommandSecurityMiddleware implements Middleware
{
    /**
     * @var CommandNameExtractor
     */
    private $commandNameExtractor;

    /**
     * @var SecurityLocator
     */
    private $securityLocator;

    /**
     * @var MethodNameInflector
     */
    private $methodNameInflector;

    /**
     * @param CommandNameExtractor $commandNameExtractor
     * @param SecurityLocator     $securityLocator
     * @param MethodNameInflector  $methodNameInflector
     */
    public function __construct(
        CommandNameExtractor $commandNameExtractor,
        SecurityLocator $securityLocator,
        MethodNameInflector $methodNameInflector
    ) {
        $this->commandNameExtractor = $commandNameExtractor;
        $this->securityLocator = $securityLocator;
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
        $security = $this->securityLocator->getValidatorForCommand($commandName);
        $methodName = $this->methodNameInflector->inflect($command, $security);

        // is_callable is used here instead of method_exists, as method_exists
        // will fail when given a handler that relies on __call.
        if (!is_callable([$security, $methodName])) {
            throw CanNotInvokeSecurityException::forCommand(
                $command,
                "Method '{$methodName}' does not exist on handler"
            );
        }

        $security->{$methodName}($command);

        return $next($command);
    }
}