<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors;

use TheRestartProject\RepairDirectory\Tactician\Authorizer\Exceptions\CannotDetermineCommandNameException;

/**
 * Interface CommandNameExtractor
 *
 * @category Extractor
 * @package  TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface CommandNameExtractor
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
    public function extract($command);
}
