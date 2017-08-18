<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Parameter;
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
    public function findAll()
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
    public function findById($uid)
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
     * @param Point   $geolocation The location to search by
     * @param integer $radius      The radius, in miles, that Businesses must be within
     * @param array   $criteria    An additional set of properties to match
     *
     * @return array
     */
    public function findByLocation($geolocation, $radius, $criteria)
    {
        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(Business::class, 'b');

        $sql = "SELECT *, AsText(b.geolocation) AS geolocation FROM businesses b WHERE 
                  MBRContains(
                    LineString(
                      Point(:x - :radius / (69 * COS(RADIANS(:y))), :y - :radius / 69),
                      Point(:x + :radius / (69 * COS(RADIANS(:y))), :y + :radius / 69)
                    ),
                    b.geolocation
                  )
                  AND ST_Distance_Sphere(Point(:x, :y), b.geolocation) <= :radius * 1000";

        $radiusKm = $radius * 1.60934;
        $parameters = [
            'x' => $geolocation->getLongitude(),
            'y' => $geolocation->getLatitude(),
            'radius' => $radiusKm
        ];

        if (count($criteria)) {
            $dqlQuery = $this->queryFromCriteria($criteria);

            $additionalSQL = $dqlQuery->getDQL();
            $additionalParameters = $this->getParametersFromDoctrineQuery($dqlQuery);

            $additionalWhere = substr($additionalSQL, strpos($additionalSQL, 'WHERE') + 6);
            $sql .= " AND $additionalWhere";

            $parameters = array_merge($parameters, $additionalParameters);
        }

        $query = $this->entityManager->createNativeQuery(
            $sql,
            $rsm
        );
        $query->setParameters($parameters);

        return $query->getResult();
    }

    /**
     * Finds businesses that match an array of [ property => value ].
     *
     * @param array $criteria The [ property => value ] array to match against businesses
     *
     * @return array All matching businesses
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
        $queryBuilder = $this->businessRepository->createQueryBuilder('b');
        $queryBuilder->select('b');
        foreach ($criteria as $key => $value) {
            if (is_array($value)) {
                // business should be returned if any of its categories match any of the query categories
                // so we use `orWhere()`
                foreach ($value as $i => $item) {
                    $queryBuilder->orWhere("b.$key LIKE :${key}_$i");
                    $queryBuilder->setParameter("${key}_$i", "%$item%");
                }
                continue;
            }

            $queryBuilder->andWhere("b.$key = :$key");
            $queryBuilder->setParameter($key, $value);
        }
        return $queryBuilder->getQuery();
    }

    /**
     * Converts the parameters in a doctrine Query (as returned by queryFromCriteria)
     * into a [ key => value ] array.
     *
     * @param Query $query The query to extract parameters from
     *
     * @return array
     */
    private function getParametersFromDoctrineQuery(Query $query)
    {
        $parameters = [];
        $doctrineParameters = $query->getParameters()->toArray();
        foreach ($doctrineParameters as $doctrineParameter) {
            /**
             * A parameter to add to the $parameters array
             *
             * @var Parameter $doctrineParameter
             */
            $parameters[$doctrineParameter->getName()] = $doctrineParameter->getValue();
        }
        return $parameters;
    }
}
