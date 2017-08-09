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
     * @param integer $radius The radius, in miles, that Businesses must be within
     * @param array $criteria An additional set of properties to match
     *
     * @return array
     */
    public function findByLocation($geolocation, $radius, $criteria)
    {
        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(Business::class, 'b');

        $sql = "SELECT *, AsText(b.geolocation) as geolocation FROM businesses b WHERE 
                  MBRContains(
                    LineString(
                      Point(:x - :radius / (69 * COS(RADIANS(:y))), :y - :radius / 69),
                      Point(:x + :radius / (69 * COS(RADIANS(:y))), :y + :radius / 69)
                    ),
                    b.geolocation
                  )
                  AND ST_Distance_Sphere(Point(:x, :y), b.geolocation) <= :radius * 1000";

        if (count($criteria)) {
            $additionalSQL = $this->queryFromCriteria($criteria)->getDQL();
            $where = substr($additionalSQL, strpos($additionalSQL, 'WHERE') + 6);
            $sql .= " AND $where";
        }

        $radiusKm = $radius * 1.60934;
        $query = $this->entityManager->createNativeQuery(
            $sql,
            $rsm
        );

        $query->setParameter('x', $geolocation->getLongitude());
        $query->setParameter('y', $geolocation->getLatitude());
        $query->setParameter('radius', $radiusKm);

        return $query->getResult();
    }

    /**
     * Finds businesses that match an array of [ property => value ].
     *
     * @param array $criteria
     *
     * @return array
     */
    public function findBy($criteria)
    {
        $query = $this->queryFromCriteria($criteria);
        return $query->getResult();
    }

    private function queryFromCriteria($criteria) {
        $qb = $this->businessRepository->createQueryBuilder('b');
        $qb->select('b');
        foreach ($criteria as $key => $value) {
            $qb->andWhere("b.$key = '$value'");
        }
        return $qb->getQuery();
    }
}
