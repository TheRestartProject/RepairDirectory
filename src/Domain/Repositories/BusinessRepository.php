<?php

namespace TheRestartProject\RepairDirectory\Domain\Repositories;


use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;

/**
 * Interface BusinessRepository
 *
 * @category Interface
 * @package  TheRestartProject\RepairDirectory\Domain\Repositories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface BusinessRepository
{

    /**
     * Add a Business to the repository.
     *
     * @param Business $business The Business to add
     *
     * @return void
     */
    public function add(Business $business);

    /**
     * Get all Businesses from the repository.
     *
     * @param User $user
     * @param bool $seeall
     *
     * @return array
     */
    public function findAll($user, $seeall = false);

    /**
     * Finds the business or returns null
     *
     * @param integer $uid The uid of the business to find
     * @param User $user
     * @param bool $seeall
     *
     * @return Business|null
     */
    public function findById($uid, $user, $seeall = false);

    /**
     * Finds businesses that match an array of [ property => value ].
     *
     * @param array $criteria The [ property => value ] array to match against businesses
     *
     * @return array
     */
    public function findBy($criteria);

    /**
     * Finds businesses within $radius miles of the provided [lat, lng]
     *
     * @param Point $geolocation The location to search by
     * @param integer $radius The radius in miles
     * @param array $criteria An additional set of properties to match
     *
     * @return array
     */
    public function findByLocation($geolocation, $radius, $criteria);

    /**
     * Remove a business from the repository
     *
     * @param Business $business The business to remove
     *
     * @return void
     */
    public function remove(Business $business);

    /**
     * Find the id of the area which corresponds to a lat/lng.
     *
     * @param float $lat
     * @param float $lng
     *
     * @return integer
     */
    public function findLocalArea($lat, $lng);
}