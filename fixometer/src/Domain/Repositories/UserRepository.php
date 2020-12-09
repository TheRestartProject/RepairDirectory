<?php

namespace TheRestartProject\Fixometer\Domain\Repositories;

use TheRestartProject\Fixometer\Domain\Entities\User;

/**
 * Interface UserRepository
 *
 * @category Repository
 * @package  TheRestartProject\Fixometer\Domain\Repositories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface UserRepository
{
    /**
     * Finds all users, or empty collection if none
     *
     * @return \TheRestartProject\Fixometer\Domain\Entities\User[]
     */
    public function findAll();

    /**
     * Find a single user or return null
     *
     * @param int $uid The unique id for the user
     *
     * @return User|null
     */
    public function find($uid);

    /**
     * Finds users that match an array of [ property => value ].
     *
     * @param array $criteria The [ property => value ] array to match against users
     *
     * @return array
     */
    public function findBy($criteria);

    /**
     * Returns true if the user exists
     *
     * @param int $uid The unique id for the user
     *
     * @return bool
     */
    public function hasUserById($uid);
}