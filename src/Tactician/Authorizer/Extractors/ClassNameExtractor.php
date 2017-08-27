<?php

namespace TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors;
use TheRestartProject\RepairDirectory\Tactician\Authorizer\Extractors\CommandNameExtractor;

/**
 * Class ClassNameExtractor
 *
 * @category
 * @package  TheRestartProject\RepairDirectory\Tactician\Validator
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class ClassNameExtractor implements CommandNameExtractor
{
    /**
     * {@inheritdoc}
     */
    public function extract($command)
    {
        return get_class($command);
    }
}