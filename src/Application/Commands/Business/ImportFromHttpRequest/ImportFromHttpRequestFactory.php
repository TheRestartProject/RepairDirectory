<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;

use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Application\Util\StringUtil;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

/**
 * Factory to create the ImportFromHttpRequestCommand
 *
 * This factory creates the command from the http Request object. It transforms some
 * fields from the request as required, and also adds geocoding data derived from
 * the address.
 *
 * @category Factory
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ImportFromHttpRequestFactory
{
    /**
     * The geocoder to geocode the address fields
     *
     * @var Geocoder
     */
    private $geocoder;

    /**
     * Constructs the factory with the geocoder
     *
     * @param Geocoder $geocoder The geocoder from geocoding address data
     *
     * @return self
     */
    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * Makes the command from the request data. It also decorates and transforms the data as required
     *
     * @param Request  $request    The request object to make the command from
     * @param int|null $businessId The id of the existing business or null if business is new
     *
     * @return ImportFromHttpRequestCommand
     */
    public function makeFromRequest(Request $request, $businessId = null)
    {
        $data = $request->all();

        $data = $this->ensureDefaults($data);

        $data = $this->transformRequestData($data);

        $data = $this->geocodeData($data);

        return new ImportFromHttpRequestCommand($data, $businessId);

    }

    /**
     * Transforms the request data, converting the type of each value to that of the corresponding Business field.
     *
     * @param array $data The HTTP Request data
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function ensureDefaults($data)
    {
        $defaults = [
            'categories' => [],
            'warrantyOffered' => false
        ];

        return array_merge($defaults, $data);
    }

    /**
     * Transforms the request data, converting the type of each value to that of the corresponding Business field.
     *
     * @param array $data The HTTP Request data
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function transformRequestData($data)
    {
        if (array_key_exists('warrantyOffered', $data)) {
            $data['warrantyOffered'] = $data['warrantyOffered'] === 'Yes';
        }

        if (array_key_exists('productsRepaired', $data)) {
            $data['productsRepaired'] = StringUtil::stringToArray($data['productsRepaired']);
        }

        if (array_key_exists('authorisedBrands', $data)) {
            $data['authorisedBrands'] = StringUtil::stringToArray($data['authorisedBrands']);
        }

        return $data;
    }

    /**
     * Decorates the data with Geocoding data derived from the address and postcode fields
     *
     * @param array $data The HTTP Request data
     *
     * @return array
     */
    protected function geocodeData($data)
    {
        if (!isset($data['geolocation']) && isset($data['address'], $data['postcode'])) {
            $point = $this->geocoder->geocode($data['postcode']);

            if ($point) {
                $data['geolocation'] = [
                    'latitude' => $point->getLatitude(),
                    'longitude' => $point->getLongitude()
                ];
            }
        }

        return $data;
    }
}
