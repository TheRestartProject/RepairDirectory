<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Locators;

use Psr\Container\ContainerInterface;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions\MissingAuthorizerException;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Locators\AuthorizerLocator;

/**
 * Locates the authorizer from within a container
 *
 * @category Locator
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Locator
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class ContainerLocator implements AuthorizerLocator
{
    /**
     * The container to locate the authorizer
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * The collection of Command/CommandAuthorizer
     *
     * @var array
     */
    protected $commandNameToAuthorizerMap = [];

    /**
     * Constructs the locator
     *
     * @param ContainerInterface $container                  The container
     * @param array              $commandNameToAuthorizerMap The map of command name to authorizer name
     *
     * @return self
     */
    public function __construct(
        ContainerInterface $container,
        array $commandNameToAuthorizerMap = []
    ) {
        $this->container = $container;
        $this->addAuthorizers($commandNameToAuthorizerMap);
    }

    /**
     * Bind a handler instance to receive all commands with a certain class
     *
     * @param string $security    Security to receive class
     * @param string $commandName Can be a class name or name of a NamedCommand
     *
     * @return void
     */
    public function addAuthorizer($security, $commandName)
    {
        $this->commandNameToAuthorizerMap[$commandName] = $security;
    }

    /**
     * Allows you to add multiple handlers at once.
     *
     * The map should be an array in the format of:
     *  [
     *      'AddTaskCommand'      => 'AddTaskCommandHandler',
     *      'CompleteTaskCommand' => 'CompleteTaskCommandHandler',
     *  ]
     *
     * @param array $commandNameToAuthorizerMap Map of Command names to authorizer names
     *
     * @return void
     */
    public function addAuthorizers(array $commandNameToAuthorizerMap)
    {
        foreach ($commandNameToAuthorizerMap as $commandName => $authorizer) {
            $this->addAuthorizer($authorizer, $commandName);
        }
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName The name of the command to authorize
     *
     * @return object
     *
     * @throws MissingAuthorizerException
     */
    public function getAuthorizerForCommand($commandName)
    {
        if (!isset($this->commandNameToAuthorizerMap[$commandName])) {
            throw MissingAuthorizerException::forCommand($commandName);
        }

        $serviceId = $this->commandNameToAuthorizerMap[$commandName];

        return $this->container->get($serviceId);
    }
}
