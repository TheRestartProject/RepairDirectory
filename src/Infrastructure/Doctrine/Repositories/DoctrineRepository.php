<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Abstract class that can be used for repositories that should work with Doctrine ORM
 *
 * @category Repository
 * @package  TheRestartProject\RepairDirectory\Application\Auth
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
     * DoctrineBusinessRepository constructor.
     *
     * @param EntityManager $entityManager The Doctrine Entity Manager (autowired)
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->getEntityClass());
    }

    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    abstract protected function getEntityClass();
}