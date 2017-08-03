<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

class Point
{
    private $latitude;
    private $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    public function toJson()
    {
        $json = get_object_vars($this);
        return $json;
    }
}