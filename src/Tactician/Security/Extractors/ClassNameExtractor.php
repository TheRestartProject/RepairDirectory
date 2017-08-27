<?php

namespace TheRestartProject\RepairDirectory\Tactician\Security\Extractors;

/**
 * Class ClassNameExtractor
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