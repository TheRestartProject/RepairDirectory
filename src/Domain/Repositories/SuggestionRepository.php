<?php

namespace TheRestartProject\RepairDirectory\Domain\Repositories;

use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;

/**
 * Interface SuggestionRepository
 *
 * @category Interface
 * @package  TheRestartProject\RepairDirectory\Domain\Repositories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface SuggestionRepository
{

    /**
     * Add a Suggestion to the repository.
     *
     * @param Suggestion $suggestion The Suggestion to add
     *
     * @return void
     */
    public function add(Suggestion $suggestion);

    /**
     * Finds suggestions that are for the given field and start with the given prefix.
     * 
     * @param string $field The field that the suggestions should be fore
     * @param string $prefix All returned suggestions should have values that start with this prefix
     * 
     * @return array
     */
    public function find($field, $prefix);

    public function findAll();
}
