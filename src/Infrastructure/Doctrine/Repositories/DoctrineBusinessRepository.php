<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
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

    /**
     * Finds businesses within 5 miles of the provided [lat, lng]
     *
     * It first finds businesses that are within a bounding box, in order to make use of spatial indexes.
     * This is done by MBRContains.
     *
     * It then also checks that these businesses are within the bounding circle.
     * This is done by ST_Distance_Sphere
     *
     * @param Point $geolocation The location to search by
     *
     * @return array
     */
    public function findByLocation($geolocation)
    {
        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(Business::class, 'b');
        $query = $this->entityManager->createNativeQuery(
            "SELECT *, AsText(b.geolocation) as geolocation FROM businesses b WHERE 
                  MBRContains(
                    LineString(
                      Point(:x - :radius, :y - :radius),
                      Point(:x + :radius, :y + :radius)
                    ),
                    b.geolocation
                  )
                  AND ST_Distance_Sphere(Point(:x, :y), b.geolocation) <= :radius",
            $rsm
        );
        $query->setParameter('x', $geolocation->getLatitude());
        $query->setParameter('y', $geolocation->getLongitude());
        $query->setParameter('radius', 5000);

        return $query->getResult();
    }
}
