<?php

namespace TheRestartProject\RepairDirectory\Tactician\Security\Inflectors;


interface MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command
     * @param object $commandAuthorizer
     *
     * @return string
     */
    public function inflect($command, $commandAuthorizer);
}