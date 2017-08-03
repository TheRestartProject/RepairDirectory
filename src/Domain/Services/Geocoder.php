<?php

namespace TheRestartProject\RepairDirectory\Domain\Services;


use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;

/**
 * Interface Geocoder
 *
 * @category Geocoder
 * @package  TheRestartProject\RepairDirectory\Domain\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
interface Geocoder
{

    /**
     * Find the [lat, lng] of a business
     *
     * @param string $address The address to geolocate
     *
     * @return Point The location of the address
     */
    public function geocode($address);
}
