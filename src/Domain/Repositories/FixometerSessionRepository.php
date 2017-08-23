<?php

namespace TheRestartProject\RepairDirectory\Domain\Repositories;

use TheRestartProject\RepairDirectory\Domain\Models\FixometerSession;

/**
 * Implementation of the StatefulGuard that uses the FixometerSession
 *
 * @category Repository
 * @package  TheRestartProject\RepairDirectory\Domain\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface FixometerSessionRepository
{
    /**
     * Find a FixometerSession by its session token
     *
     * @param string $session The random string that represents a session
     *
     * @return FixometerSession|null
     */
    public function findOneBySession($session);


    /**
     * Add a new session
     *
     * @param FixometerSession $session The Session to add
     *
     * @return void
     */
    public function add(FixometerSession $session);
}