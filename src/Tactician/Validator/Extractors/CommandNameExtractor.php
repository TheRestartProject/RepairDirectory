<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Extractors;

use TheRestartProject\RepairDirectory\Tactician\Validator\CannotDetermineCommandNameException;

/**
 * Interface for extracting a command name
 *
 * @category Extractor
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator\Extractors
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface CommandNameExtractor
{
    /**
     * Extract the name from a command
     *
     * @param object $command The command to extract the name from
     *
     * @return string
     *
     * @throws CannotDetermineCommandNameException
     */
    public function extract($command);
}
