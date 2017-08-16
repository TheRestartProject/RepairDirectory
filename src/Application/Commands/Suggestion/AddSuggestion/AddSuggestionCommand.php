<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion;

/**
 * Command to add a suggestion to the db
 *
 * @category Command
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Suggestion\AddSuggestion;
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class AddSuggestionCommand
{
    private $field;
    private $value;

    /**
     * Creates the AddSuggestionCommand from a field and value
     *
     * @param string $field The field that the suggestion is for
     * @param string $value The value of the suggestion
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
