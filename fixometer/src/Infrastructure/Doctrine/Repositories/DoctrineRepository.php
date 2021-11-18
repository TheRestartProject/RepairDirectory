<?php

namespace TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories;

use LaravelDoctrine\ORM\IlluminateRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Abstract class that can be used for repositories that should work with Doctrine ORM
 *
 * @category Repository
 * @package  TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
abstract class DoctrineRepository
{
    /**
     * The Doctrine Entity Manager
     *
     * @var EntityManager
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
     * @param IlluminateRegistry $registry The Doctrine Entity Manager (autowired)
     */
    public function __construct(IlluminateRegistry $registry)
    {
        $this->entityManager = $registry->getManagerForClass($this->getEntityClass());
        $this->repository = $this->entityManager->getRepository($this->getEntityClass());
    }

    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    abstract protected function getEntityClass();
}