<?php

namespace TheRestartProject\RepairDirectory\Domain\Services;


use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Interface BusinessRepository
 *
 * @category Geocoder
 * @package  TheRestartProject\RepairDirectory\Domain\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface BusinessGeocoder
{

    /**
     * Find the [lat, lng] of a business
     *
     * @param Business $business The Business to geolocate
     *
     * @return array The [lat, lng] of the business
     */
    public function geocode(Business $business);
}
