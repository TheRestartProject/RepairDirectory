<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Domain\Repositories\SuggestionRepository;

/**
 * Class DoctrineSuggestionRepository
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Repositories
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineSuggestionRepository extends DoctrineRepository implements SuggestionRepository
{
    /**
     * Register a new suggestion with the entity manager.
     *
     * @param Suggestion $suggestion The Suggestion to add
     *
     * @return void
     */
    public function add(Suggestion $suggestion)
    {
        $this->entityManager->persist($suggestion);
    }

    /**
     * Finds suggestions that are for the given field and start with the given prefix.
     *
     * @param string $field  The field that the suggestions should be fore
     * @param string $prefix All returned suggestions should have values that start with this prefix
     *
     * @return array
     */
    public function find($field, $prefix)
    {
        return $this->repository->createQueryBuilder('s')
            ->where('s.field = :field')
            ->andWhere('s.value LIKE :value')
            ->setParameter('field', $field)
            ->setParameter('value', $prefix . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    protected function getEntityClass()
    {
        return Suggestion::class;
    }
}
