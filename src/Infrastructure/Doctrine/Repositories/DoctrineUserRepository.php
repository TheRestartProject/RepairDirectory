<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Domain\Repositories\UserRepository;


/**
 * Class DoctrineUserRepository
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
     * @return User[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Find a single user or return null
     *
     * @param int $id The unique id for the user
     *
     * @return User|null
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Returns true if the user exists
     *
     * @param int $id The unique id for the user
     * @return bool
     */
    public function hasUserById($id)
    {
        $user = $this->find($id);

        return $user !== null;
    }
}