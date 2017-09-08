<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors;

/**
 * Extracts the command's name from the command's class name
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
     * @param object $command The command to extract a name from
     *
     * @return string
     *
     * @throws CannotDetermineCommandNameException
     */
    public function extract($command)
    {
        return get_class($command);
    }
}
