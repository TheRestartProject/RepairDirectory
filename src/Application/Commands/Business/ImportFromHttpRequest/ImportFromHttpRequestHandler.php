<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;


use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Access\Gate;
use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Exceptions\EntityNotFoundException;
use TheRestartProject\RepairDirectory\Application\Util\StringUtil;
use TheRestartProject\RepairDirectory\Application\Validators\CustomBusinessValidator;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

/**
 * Handles the ImportFromCsvRowCommand to import a Business
 *
 * @category CommandHandler
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromHttpRequestHandler
{
    /**
     * An implementation of the BusinessRepository
     *
     * @var BusinessRepository
     */
    private $repository;

    /**
     * The geocoder to get [lat, lng] of business
     *
     * @var Geocoder
     */
    private $geocoder;

    /**
     * Creates the handler for the ImportBusinessFromCsvRowCommand
     *
     * @param BusinessRepository $repository An implementation of the BusinessRepository
     * @param Geocoder           $geocoder   Geocoder to get [lat, lng] of business
     *
     * @return $this
     */
    public function __construct(BusinessRepository $repository, Geocoder $geocoder)
    {
        $this->repository = $repository;
        $this->geocoder = $geocoder;
    }

    /**
     * Handles the Command by importing a Business from a CSV row
     *
     * @param ImportFromHttpRequestCommand $command The command to handle
     *
     * @return Business
     *
     * @throws EntityNotFoundException
     * @throws BusinessValidationException
     * @throws AuthorizationException
     */
    public function handle(ImportFromHttpRequestCommand $command)
    {
        $data = $command->getData();

        $businessUid = $command->getBusinessUid();
        $isCreate = !(boolean) $businessUid;
        
        $business = $isCreate ? new Business() : $this->repository->findById($businessUid);

        if (!$business) {
            throw new EntityNotFoundException("Business with id of {$businessUid} could not be found");
        }

        $data = $this->transformRequestData($data);

        $this->updateValues($business, $data);

        $business->setGeolocation($this->geocoder->geocode($business->getAddress() . ', ' . $business->getPostcode()));

        if ($isCreate) {
            $this->repository->add($business);
        }
        
        return $business;
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
    private function transformRequestData($data) 
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
     * Update the $business fields from a $data array
     *
     * @param Business $business The business to update
     * @param array    $data     An [ $key => $value ] array of fields to update
     *
     * @return void
     */
    private function updateValues($business, $data)
    {
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($business, $setter)) {
                $business->{$setter}($value);
            }
        }
    }

    /**
     * Throws exception if logged in user is not authorized
     *
     * @param bool     $isCreate Whether the business is new or not
     * @param Business $business The business to check against
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    protected function authorize($isCreate, $business)
    {
        if ($isCreate) {
            $this->gate->authorize('create', Business::class);
        } else {
            $this->gate->authorize('update', $business);
        }
    }
}
