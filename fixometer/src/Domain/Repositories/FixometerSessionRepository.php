<?php

namespace TheRestartProject\Fixometer\Domain\Repositories;

use TheRestartProject\Fixometer\Domain\Entities\FixometerSession;

/**
 * Implementation of the StatefulGuard that uses the FixometerSession
 *
 * @category Repository
 * @package  TheRestartProject\Fixometer\Domain\Repositories
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

    /**
     * Remove a session
     *
     * @param FixometerSession $session The Session to remove
     *
     * @return void
     */
    public function remove(FixometerSession $session);

    /**
     * Find a session by its Id
     *
     * @param int $uid The Unique id for the session
     *
     * @return \TheRestartProject\Fixometer\Domain\Entities\FixometerSession|null
     */
    public function find($uid);

}