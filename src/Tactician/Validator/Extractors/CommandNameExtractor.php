<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Extractors;


use TheRestartProject\RepairDirectory\Tactician\Validator\CannotDetermineCommandNameException;

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