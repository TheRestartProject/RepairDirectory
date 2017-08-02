<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Services;

use Geocoder\Laravel\ProviderAndDumperAggregator;
use Geocoder\Model\AddressCollection;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Services\BusinessGeocoder;

class BusinessGeocoderImpl implements BusinessGeocoder
{

    /**
     * @var \Geocoder\Geocoder
     */
    private $geocoder;

    public function __construct($geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * Find the [lat, lng] of a business
     *
     * @param Business $business The Business to geolocate
     *
     * @return array The [lat, lng] of the business
     */
    public function geocode(Business $business)
    {
        $addressString = $business->getAddress() . ', ' . $business->getPostcode();
        /** @var ProviderAndDumperAggregator $geocodeResponse */
        $geocodeResponse = $this->geocoder->geocode($addressString);
        $addressCollection = $geocodeResponse->get();
        $address = $addressCollection->get(0);
        if ($address) {
            return [$address->getLatitude(), $address->getLongitude()];
        }
        return [0, 0];
    }
}