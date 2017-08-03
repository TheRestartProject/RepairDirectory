<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Class DoctrineBusinessRepository
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Repositories
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineBusinessRepository implements BusinessRepository
{
    /**
     * The Doctrine Entity Manager
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * The Doctrine Repository for businesses
     *
     * @var EntityRepository
     */
    private $businessRepository;

    /**
     * DoctrineBusinessRepository constructor.
     *
     * @param EntityManager $entityManager The Doctrine Entity Manager (autowired)
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->businessRepository = $entityManager->getRepository(Business::class);
    }

    /**
     * Register a new business with the entity manager.
     * Should be persisted with the DoctrinePersister service.
     *
     * @param Business $business The Business to add
     *
     * @return void
     */
    public function add(Business $business)
    {
        $this->entityManager->persist($business);
    }

    /**
     * Get all businesses from the repository.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->businessRepository->findAll();
    }

    /**
     * Finds the business or returns null
     *
     * @param integer $uid The id of the business to find
     *
     * @return Business|null
     */
    public function get($uid)
    {
        /**
         * The business to update
         *
         * @var Business $business
         */
        $business = $this->businessRepository->find($uid);
        return $business;
    }
}
