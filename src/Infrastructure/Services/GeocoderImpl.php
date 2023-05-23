<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Services;

use Geocoder\Exception\ChainNoResult;
use Geocoder\Laravel\ProviderAndDumperAggregator;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;
use Geocoder\Query\GeocodeQuery;

/**
 * Implements the Geocoder domain interface using the Laravel Geocoder library.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class GeocoderImpl implements Geocoder
{

    /**
     * The Laravel Geocoder service
     *
     * @var ProviderAndDumperAggregator
     */
    private $geocoder;

    /**
     * GeocoderImpl constructor.
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
     * @param string $address The address to geolocate.  Generally this should be a postcode, since geocoders other
     * than Google are not very good at handling the more flexible address formats.
     *
     * @return Point|null The location of the address, or null if not found
     */
    public function geocode($address)
    {
        try {
            $geocodeResponse = $this->geocoder->geocodeQuery(GeocodeQuery::create($address)->withData('location_type', 'postcode'));
            $addressCollection = $geocodeResponse->get();
            $address = $addressCollection->get(0);
            if ($address) {
                return new Point($address->getCoordinates()->getLatitude(), $address->getCoordinates()->getLongitude());
            }
        } catch (ChainNoResult $e) {
            return null;
        }

        return null;
    }
}
