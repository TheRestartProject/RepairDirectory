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
class DoctrineSuggestionRepository implements SuggestionRepository
{
    /**
     * The Doctrine Entity Manager
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * The Doctrine Repository for suggestions
     *
     * @var EntityRepository
     */
    private $suggestionRepository;

    /**
     * DoctrineBusinessRepository constructor.
     *
     * @param EntityManager $entityManager The Doctrine Entity Manager (autowired)
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->suggestionRepository = $entityManager->getRepository(Suggestion::class);
    }

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
     * @param string $field The field that the suggestions should be fore
     * @param string $prefix All returned suggestions should have values that start with this prefix
     *
     * @return array
     */
    public function find($field, $prefix)
    {
        return $this->suggestionRepository->createQueryBuilder('s')
            ->where('s.field = :field')
            ->andWhere('s.value LIKE :value')
            ->setParameter('field', $field)
            ->setParameter('value', $prefix . '%')
            ->getQuery()
            ->getResult();
    }
}
