<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer;

use League\Tactician\Middleware;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions\CanNotInvokeAuthorizerException;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors\CommandNameExtractor;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Inflectors\MethodNameInflector;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Locators\AuthorizerLocator;
use TheRestartProject\RepairDirectory\Tactician\Validator\CanNotInvokeHandlerException;
use TheRestartProject\RepairDirectory\Tactician\Validator\CanNotInvokeSecurityException;

/**
 * Class CommandSecurityMiddleware
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Security
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class CommandAuthorizerMiddleware implements Middleware
{
    /**
     * @var \TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors\CommandNameExtractor
     */
    private $commandNameExtractor;

    /**
     * @var \TheRestartProject\RepairDirectory\Tactician\Authorizer\Locators\AuthorizerLocator
     */
    private $securityLocator;

    /**
     * @var MethodNameInflector
     */
    private $methodNameInflector;

    /**
     * @param \TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors\CommandNameExtractor $commandNameExtractor
     * @param \TheRestartProject\RepairDirectory\Tactician\Authorizer\Locators\AuthorizerLocator     $securityLocator
     * @param MethodNameInflector  $methodNameInflector
     */
    public function __construct(
        CommandNameExtractor $commandNameExtractor,
        AuthorizerLocator $securityLocator,
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
        $security = $this->securityLocator->getAuthorizerForCommand($commandName);
        $methodName = $this->methodNameInflector->inflect($command, $security);

        // is_callable is used here instead of method_exists, as method_exists
        // will fail when given a handler that relies on __call.
        if (!is_callable([$security, $methodName])) {
            throw CanNotInvokeAuthorizerException::forCommand(
                $command,
                "Method '{$methodName}' does not exist on authorizer"
            );
        }

        $security->{$methodName}($command);

        return $next($command);
    }
}