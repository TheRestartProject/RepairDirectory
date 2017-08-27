<?php

namespace TheRestartProject\RepairDirectory\Tactician\Validator\Extractors;

/**
 * Extracts the command name from the class name of the command
 *
 * @category Extractor
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class ClassNameExtractor implements CommandNameExtractor
{
    /**
     * Extract the name from a command
     *
     * @param object $command The command to extract the name from
     *
     * @return string
     */
    public function extract($command)
    {
        return get_class($command);
    }
}