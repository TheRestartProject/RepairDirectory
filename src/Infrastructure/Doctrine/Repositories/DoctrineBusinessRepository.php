<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\Fixometer\Domain\Entities\User;

/**
 * Class DoctrineBusinessRepository
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Repositories
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineBusinessRepository extends DoctrineRepository implements BusinessRepository
{
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
     * @param User $user
     * @param bool $seeall
     *
     * @return array
     */
    // TODO We are using Basic Auth at the moment.
    public function findAll($user, $seeall = TRUE)
    {
        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(Business::class, 'b');

        if ($seeall || $user->isSuperAdmin()) {
            // If we are a superadmin we can see all businesses.
            $sql = "SELECT b.*, ST_AsText(b.geolocation) AS geolocation, areas.uid AS local_area FROM businesses b
            LEFT JOIN areas ON b.local_area = areas.uid;";

            $query = $this->entityManager->createNativeQuery(
                $sql,
                $rsm
            );
        } else {
            // If we are a regional admin or an editor then we can only see businesses within regions that we have been
            // assigned.
            //
            // "Within a region" means that the geolocation of the business is inside the polygon of the region.
            $sql = "SELECT b.*, ST_AsText(b.geolocation) AS geolocation, areas.uid AS local_area FROM businesses b
            INNER JOIN regions ON ST_Contains(regions.polygon, b.geolocation)        
            INNER JOIN users_regions ON regions.uid = users_regions.region
            LEFT JOIN areas ON b.local_area = areas.uid
            WHERE users_regions.user = " . intval($user->getUid());

            $query = $this->entityManager->createNativeQuery(
                $sql,
                $rsm
            );
        }

        $businesses = $query->getResult();
        $this->setLocalAreas($businesses);

        return $businesses;
    }

    /**
     * Finds the business or returns null.
     *
     * This will only find businesses within a region that the user has access to.
     *
     * @param integer $uid The id of the business to find
     * @param User $user
     * @param bool $seeall
     *
     * @return Business|null
     */
    // TODO We are using Basic Auth at the moment.
    public function findBusinessForUser($uid, $user, $seeall = TRUE)
    {
        $ret = null;

        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(Business::class, 'b');

        if ($seeall || $user->isSuperAdmin()) {
            // If we are a superadmin we can see all businesses.
            $sql = "SELECT b.*, ST_AsText(b.geolocation) AS geolocation, areas.uid AS local_area FROM businesses b
                LEFT JOIN areas ON b.local_area = areas.uid WHERE b.uid = " . intval($uid);

            $query = $this->entityManager->createNativeQuery(
                $sql,
                $rsm
            );
        } else {
            $sql = "SELECT b.*, ST_AsText(b.geolocation) AS geolocation, areas.uid AS local_area FROM businesses b
                INNER JOIN regions ON ST_Contains(regions.polygon, b.geolocation)
                INNER JOIN users_regions ON regions.uid = users_regions.region
                LEFT JOIN areas ON b.local_area = areas.uid
                WHERE users_regions.user = " . intval($user->getUid()) . " AND b.uid = " . intval($uid);

            $query = $this->entityManager->createNativeQuery(
                $sql,
                $rsm
            );
        }

        $businesses = $query->getResult();

        if (count($businesses)) {
            $this->setLocalAreas($businesses);
            $ret = $businesses[0];
        }

        return $ret;
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
     * This is for end-users on the public site - so we do not need to apply any restrictions based on
     * regions as we would if this was for the admin section.
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
        $rsm->addRootEntityFromClassMetadata(Business::class, 'b0_');

        $sql = "SELECT *, ST_AsText(b0_.geolocation) AS geolocation FROM businesses b0_
                WHERE
                  MBRContains(
                    LineString(
                      Point(:x - :radius / (69 * COS(RADIANS(:y))), :y - :radius / 69),
                      Point(:x + :radius / (69 * COS(RADIANS(:y))), :y + :radius / 69)
                    ),
                    b0_.geolocation
                  )
                  AND ST_Distance_Sphere(Point(:x, :y), b0_.geolocation) <= :radius * 1000";

        $radiusKm = $radius * 1.60934;
        $parameters = [
            'x' => $geolocation->getLongitude(),
            'y' => $geolocation->getLatitude(),
            'radius' => $radiusKm
        ];

        if (count($criteria)) {
            $dqlQuery = $this->queryFromCriteria($criteria);

            $doctrineSQL = $dqlQuery->getSQL();
            $additionalParameters = $this->getParametersFromDoctrineQuery($dqlQuery);

            $additionalSQL = $this->convertToNamedParameters($doctrineSQL, array_keys($additionalParameters));

            $additionalWhere = substr($additionalSQL, strpos($additionalSQL, 'WHERE') + 6);
            $sql .= " AND $additionalWhere";

            $parameters = array_merge($parameters, $additionalParameters);
        }

        $query = $this->entityManager->createNativeQuery(
            $sql,
            $rsm
        );
        $query->setParameters($parameters);

        $businesses = $query->getResult();
        $this->setLocalAreas($businesses);

        return $businesses;
    }

    /**
     * Finds businesses that match an array of [ property => value ].
     *
     * This is for end-users on the public site - so we do not need to apply any restrictions based on
     * regions as we would if this was for the admin section.
     *
     * @param array $criteria The [ property => value ] array to match against businesses
     *
     * @return array All matching businesses
     */
    public function findBy($criteria)
    {
        $query = $this->queryFromCriteria($criteria);
        $businesses = $query->getResult();
        $this->setLocalAreas($businesses);
        return $businesses;
    }

    private function setLocalAreas($businesses) {
        # We have to bypass Doctrine to get the area name.  We can't use Doctrine mapping easily.
        $areas = [];

        foreach ($businesses as $business) {
            if ($business && $business->getLocalArea()) {
                $areas[] = $business->getLocalArea();
            }
        }

        $areas = array_unique($areas);

        if (count($areas)) {
            $conn = $this->entityManager->getConnection();
            $stmt = $conn->prepare("SELECT uid, name FROM areas WHERE uid IN (" . implode(',', $areas) . ");");
            $stmt->execute();
            $areas = $stmt->fetchAll();

            foreach ($businesses as $business) {
                if ($business) {
                    foreach ($areas as $area) {
                        if ($area['uid'] == $business->getLocalArea()) {
                            $business->setLocalAreaName($area['name']);
                        }
                    }
                }
            }
        }
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
        $queryBuilder->orderBy('b.positiveReviewPc', 'DESC');
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

    /**
     * Replace the '?' characters in an SQL string with each element in $parameterNames in order.
     *
     * @param string $sql            The SQL to convert to use named parameters
     * @param array  $parameterNames An array of parameter names (strings)
     *
     * @return string
     */
    private function convertToNamedParameters($sql, $parameterNames)
    {
        $newSql = $sql;
        foreach ($parameterNames as $parameterName) {
            $nextParamPos = strpos($newSql, '?');
            if ($nextParamPos !== false) {
                $newSql = substr_replace($newSql, ":$parameterName", $nextParamPos, 1);
            }
        }
        return $newSql;
    }

    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    protected function getEntityClass()
    {
        return Business::class;
    }

    /**
     * Remove a business from the repository
     *
     * @param Business $business The business to remove
     *
     * @return void
     */
    public function remove(Business $business)
    {
        $this->entityManager->remove($business);
    }

    /**
     * Find the id of the area which corresponds to a lat/lng.
     *
     * @param float $lat
     * @param float $lng
     *
     * @return integer
     */
    public function findLocalArea($lat, $lng) {
        $conn = $this->entityManager->getConnection();
        $stmt = $conn->prepare("SELECT uid FROM areas WHERE ST_Contains(areas.geometry, POINT(?,?));");
        $stmt->bindValue(1, $lng);
        $stmt->bindValue(2, $lat);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return count($res) ? $res[0]['uid'] : NULL;
    }
}
