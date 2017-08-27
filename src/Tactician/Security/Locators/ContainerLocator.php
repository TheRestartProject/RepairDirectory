<?php

namespace TheRestartProject\RepairDirectory\Tactician\Security\Locators;

use Psr\Container\ContainerInterface;
use TheRestartProject\RepairDirectory\Tactician\Security\Exceptions\MissingSecurityException;

/**
 * Class ContainerLocator
 *
 * @category Locator
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Locator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class ContainerLocator implements SecurityLocator
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * The collection of Command/CommandHandler
     *
     * @var array
     */
    protected $commandNameToSecurityMap = [];

    /**
     * @param ContainerInterface $container
     * @param array              $commandNameToSecurityMap
     */
    public function __construct(
        ContainerInterface $container,
        array $commandNameToSecurityMap = []
    ) {
        $this->container = $container;
        $this->addSecurities($commandNameToSecurityMap);
    }

    /**
     * Bind a handler instance to receive all commands with a certain class
     *
     * @param string $security   Security to receive class
     * @param string $commandName Can be a class name or name of a NamedCommand
     */
    public function addSecurity($security, $commandName)
    {
        $this->commandNameToSecurityMap[$commandName] = $security;
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
     * @param array $commandNameToValidatorMap
     */
    public function addSecurities(array $commandNameToValidatorMap)
    {
        foreach ($commandNameToValidatorMap as $commandName => $validator) {
            $this->addSecurity($validator, $commandName);
        }
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingSecurityException
     */
    public function getSecurityForCommand($commandName)
    {
        if (!isset($this->commandNameToSecurityMap[$commandName])) {
            throw MissingSecurityException::forCommand($commandName);
        }

        $serviceId = $this->commandNameToSecurityMap[$commandName];

        return $this->container->get($serviceId);
    }
}
