<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Services;

use Geocoder\Exception\ChainNoResult;
use Geocoder\Laravel\ProviderAndDumperAggregator;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Services\BusinessGeocoder;

/**
 * Implements the BusinessGeocoder interface using the Laravel Geocoder library.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class BusinessGeocoderImpl implements BusinessGeocoder
{

    /**
     * The Laravel Geocoder service
     *
     * @var ProviderAndDumperAggregator
     */
    private $geocoder;

    /**
     * BusinessGeocoderImpl constructor.
     *
     * @param ProviderAndDumperAggregator $geocoder The Laravel Geocoder service
     */
    public function __construct($geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * Find the [lat, lng] of a business
     *
     * @param Business $business The Business to geolocate
     *
     * @return array|null The [lat, lng] of the business
     */
    public function geocode(Business $business)
    {
        $addressString = $business->getAddress() . ', ' . $business->getPostcode();
        try {
            $geocodeResponse = $this->geocoder->geocode($addressString);
            $addressCollection = $geocodeResponse->get();
            $address = $addressCollection->get(0);
            if ($address) {
                return [$address->getLatitude(), $address->getLongitude()];
            }
        } catch (ChainNoResult $e) {
            return null;
        }
        return null;
    }
}
