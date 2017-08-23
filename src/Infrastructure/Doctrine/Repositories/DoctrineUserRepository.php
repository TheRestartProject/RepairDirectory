<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;


/**
 * Class DoctrineUserRepository
 *
 * @category Repository
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    protected function getEntityClass()
    {
        return User::class;
    }

    /**
     * Finds all users, or empty collection if none
     *
     * @return \TheRestartProject\Fixometer\Domain\Entities\User[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Find a single user or return null
     *
     * @param int $uid The unique id for the user
     *
     * @return User|null
     */
    public function find($uid)
    {
        return $this->repository->find($uid);
    }

    /**
     * Returns true if the user exists
     *
     * @param int $uid The unique id for the user
     *
     * @return bool
     */
    public function hasUserById($uid)
    {
        $user = $this->find($uid);

        return $user !== null;
    }
}