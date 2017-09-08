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
 * Middleware for authorizing commands
 *
 * @category TacticianMiddleware
 * @package  TheRestartProject\RepairDirectory\Tactician\Security
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class CommandAuthorizerMiddleware implements Middleware
{
    /**
     * The command name extractor
     *
     * @var Extractors\CommandNameExtractor
     */
    private $commandNameExtractor;

    /**
     * The authorizer locator
     *
     * @var Locators\AuthorizerLocator
     */
    private $authorizerLocator;

    /**
     * The method name inflector
     *
     * @var MethodNameInflector
     */
    private $methodNameInflector;

    /**
     * Constructs the middleware
     *
     * @param Extractors\CommandNameExtractor $commandNameExtractor Extracts the name of the command
     * @param Locators\AuthorizerLocator      $authorizerLocator    Locates the authorizer
     * @param MethodNameInflector             $methodNameInflector  Determines the method to be called on the authorizer
     *
     * @return self
     */
    public function __construct(
        CommandNameExtractor $commandNameExtractor,
        AuthorizerLocator $authorizerLocator,
        MethodNameInflector $methodNameInflector
    ) {
        $this->commandNameExtractor = $commandNameExtractor;
        $this->authorizerLocator = $authorizerLocator;
        $this->methodNameInflector = $methodNameInflector;
    }

    /**
     * Executes a command and optionally returns a value
     *
     * @param object   $command The command to authorized
     * @param callable $next    The next middleware
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
        $authorizer = $this->authorizerLocator->getAuthorizerForCommand($commandName);
        $methodName = $this->methodNameInflector->inflect($command, $authorizer);

        // if no validator then none has been defined.
        // go to next middleware
        if ($authorizer === null) {
            return $next($command);
        }

        // is_callable is used here instead of method_exists, as method_exists
        // will fail when given a handler that relies on __call.
        if (!is_callable([$authorizer, $methodName])) {
            throw CanNotInvokeAuthorizerException::forCommand(
                $command,
                "Method '{$methodName}' does not exist on authorizer"
            );
        }

        $authorizer->{$methodName}($command);

        return $next($command);
    }
}
