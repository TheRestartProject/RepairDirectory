<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

/**
 * Class Point
 *
 * Represents a location in the World.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class Point
{
    private $latitude;
    private $longitude;

    /**
     * Point constructor
     *
     * @param float $latitude  The latitude of the point
     * @param float $longitude The longitude of the point
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Creates a Point object from an array
     *
     * @param array $geolocation Latitude and Longitude in array
     *
     * @return self
     */
    public static function fromArray($geolocation)
    {
        if (isset($geolocation['latitude'], $geolocation['longitude'])) {
            return new self($geolocation['latitude'], $geolocation['longitude']);
        }

        return new self($geolocation[0], $geolocation[1]);
    }

    /**
     * Return the latitude of the point
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Return the longitude of the point
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Convert the instance to a [ key => value ] array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = get_object_vars($this);
        return $array;
    }
}
