<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors;


use TheRestartProject\RepairDirectory\Tactician\Security\CannotDetermineCommandNameException;

interface CommandNameExtractor
{
    /**
     * Extract the name from a command
     *
     * @param object $command
     *
     * @return string
     *
     * @throws CannotDetermineCommandNameException
     */
    public function extract($command);
}