<?php

namespace TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories;

use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;

/**
 * Class DoctrineUserRepository
 *
 * @category Repository
 * @package  TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories
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
     * Finds users that match an array of [ property => value ].
     *
     * @param array $criteria The [ property => value ] array to match against users
     *
     * @return array All matching users
     */
    public function findBy($criteria)
    {
        $query = $this->queryFromCriteria($criteria);
        return $query->getResult();
    }

    /**
     * Converts a [ property => value] array to a doctrine query that can be executed.
     *
     * @param array $criteria The [ property => value ] array to convert to a query
     *
     * @return Query
     */
    private function queryFromCriteria($criteria)
    {
        $queryBuilder = $this->repository->createQueryBuilder('b');
        $queryBuilder->select('b');
        foreach ($criteria as $criterion) {
            $field = $criterion['field'];
            $operator = $criterion['operator'];
            $value = $criterion['value'];

            // handle array contains operator
            if ($operator === Operators::CONTAINS) {
                $operator = 'LIKE';
                $value = '%' . $value . '%';
            }

            $queryBuilder->andWhere("b.$field $operator :$field");
            $queryBuilder->setParameter($field, $value);
        }
        return $queryBuilder->getQuery();
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