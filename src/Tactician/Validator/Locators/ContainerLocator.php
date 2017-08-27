<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Locators;

use Psr\Container\ContainerInterface;

/**
 * Class ContainerLocator
 * @category
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Locator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class ContainerLocator implements ValidatorLocator
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
    protected $commandNameToValidatorMap = [];

    /**
     * @param ContainerInterface $container
     * @param array              $commandNameToValidatorMap
     */
    public function __construct(
        ContainerInterface $container,
        array $commandNameToValidatorMap = []
    ) {
        $this->container = $container;
        $this->addValidators($commandNameToValidatorMap);
    }

    /**
     * Bind a handler instance to receive all commands with a certain class
     *
     * @param string $validator   Validator to receive class
     * @param string $commandName Can be a class name or name of a NamedCommand
     */
    public function addValidator($validator, $commandName)
    {
        $this->commandNameToValidatorMap[$commandName] = $validator;
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
    public function addValidators(array $commandNameToValidatorMap)
    {
        foreach ($commandNameToValidatorMap as $commandName => $validator) {
            $this->addValidator($validator, $commandName);
        }
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getValidatorForCommand($commandName)
    {
        if (!isset($this->commandNameToValidatorMap[$commandName])) {
            throw MissingHandlerException::forCommand($commandName);
        }

        $serviceId = $this->commandNameToValidatorMap[$commandName];

        return $this->container->get($serviceId);
    }
}
