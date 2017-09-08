<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Abstract class that can be used for repositories that should work with Doctrine ORM
 *
 * @category Repository
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
abstract class DoctrineRepository
{
    /**
     * The Doctrine Entity Manager
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * The Doctrine Repository for businesses
     *
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Constructs the DoctrineRepository
     *
     * @param ManagerRegistry $registry The Doctrine Entity Manager (autowired)
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $this->resolveEntityManager($registry);
        $this->repository = $this->resolveRepository();
    }

    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    abstract protected function getEntityClass();

    /**
     * Sets up the Entity manager
     *
     * @param ManagerRegistry $registry The Manager Registry for Doctrine ORM
     *
     * @return EntityManagerInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function resolveEntityManager(ManagerRegistry $registry)
    {
        /**
         * Ensures that this is an entity manager not an object manager
         *
         * @var EntityManagerInterface|null $entityManager
         */
        $entityManager = $registry->getManagerForClass($this->getEntityClass());

        if ($entityManager === null) {
            throw new \InvalidArgumentException("No Entity Manager available for this Entity Class: {$this->getEntityClass()}");
        }

        return $entityManager;
    }

    /**
     * Sets up the Entity Repository
     *
     * @return EntityRepository
     *
     * @throws \InvalidArgumentException
     */
    protected function resolveRepository()
    {
        /**
         * Ensures that this is an entity repository not object repository
         *
         * @var EntityRepository $repository
         */
        $repository = $this->entityManager->getRepository($this->getEntityClass());

        return $repository;
    }
}
