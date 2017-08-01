<?php

namespace TheRestartProject\RepairDirectory\Domain\Repositories;


use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Interface BusinessRepository
 *
 * @category Interface
 * @package  TheRestartProject\RepairDirectory\Domain\Repositories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface BusinessRepository
{

    /**
     * Add a Business to the repository. Make permanent using the Persister service.
     *
     * @param Business $business The Business to add
     *
     * @return void
     */
    public function add(Business $business);

    /**
     * Get all Businesses from the repository.
     *
     * @return array
     */
    public function getAll();

    /**
     * Finds the business or returns null
     *
     * @param integer $id The id of the business to find
     * @return Business|null
     */
    public function findById($id);
}
