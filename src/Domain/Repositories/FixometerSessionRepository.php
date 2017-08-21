<?php

namespace TheRestartProject\RepairDirectory\Domain\Repositories;

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
     * @return mixed
     */
    public function findOneBySession($session);
}