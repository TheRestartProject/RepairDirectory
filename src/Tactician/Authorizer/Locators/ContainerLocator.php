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
    protected $commandAuthorizerMap = [];

    /**
     * Constructs the locator
     *
     * @param ContainerInterface $container            The container
     * @param array              $commandAuthorizerMap The map of command name to authorizer name
     *
     * @return self
     */
    public function __construct(
        ContainerInterface $container,
        array $commandAuthorizerMap = []
    ) {
        $this->container = $container;
        $this->addAuthorizers($commandAuthorizerMap);
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
        $this->commandAuthorizerMap[$commandName] = $security;
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
     * @param array $commandAuthorizerMap Map of Command names to authorizer names
     *
     * @return void
     */
    public function addAuthorizers(array $commandAuthorizerMap)
    {
        foreach ($commandAuthorizerMap as $commandName => $authorizer) {
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
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getAuthorizerForCommand($commandName)
    {
        if (!isset($this->commandAuthorizerMap[$commandName])) {
            throw MissingAuthorizerException::forCommand($commandName);
        }

        $serviceId = $this->commandAuthorizerMap[$commandName];

        return $this->container->get($serviceId);
    }
}
