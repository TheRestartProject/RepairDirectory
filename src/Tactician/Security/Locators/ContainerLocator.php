<?php

namespace TheRestartProject\RepairDirectory\Tactician\Security\Locators;

use Psr\Container\ContainerInterface;
use TheRestartProject\RepairDirectory\Tactician\Security\Exceptions\MissingAuthorizerException;

/**
 * Class ContainerLocator
 *
 * @category Locator
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Locator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class ContainerLocator implements AuthorizerLocator
{
    /**
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
     * @param ContainerInterface $container
     * @param array              $commandNameToAuthorizerMap
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
     * @param string $security   Security to receive class
     * @param string $commandName Can be a class name or name of a NamedCommand
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
     * @param array $commandNameToAuthorizerMap
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
     * @param string $commandName
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
