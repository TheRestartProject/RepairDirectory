<?php

namespace TheRestartProject\RepairDirectory\Domain\Services;

/**
 * Interface Persister
 *
 * @category Interface
 * @package  TheRestartProject\RepairDirectory\Domain\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface Persister
{
    /**
     * Persist all changes present in entity repositories.
     *
     * @return void
     */
    public function persistChanges();
}
