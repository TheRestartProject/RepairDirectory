<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Locators;

use Psr\Container\ContainerInterface;

/**
 * Locates the validator for a command from the container
 *
 * @category Locator
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Locator
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class ContainerLocator implements ValidatorLocator
{
    /**
     * The container to look in
     *
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
     * Constructs the Locator
     *
     * @param ContainerInterface $container                 The container
     * @param array              $commandNameToValidatorMap The map of command name to validator name
     *
     * @return self
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
     *
     * @return void
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
     * @param array $commandNameToValidatorMap The array of command name to validator name
     *
     * @return void
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
     * @param string $commandName The name of the command to get the validator for
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
