<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;


use TheRestartProject\RepairDirectory\Application\Exceptions\EntityNotFoundException;
use TheRestartProject\RepairDirectory\Application\Validators\BusinessValidator;
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
    
    private $validator;

    /**
     * Creates the handler for the ImportBusinessFromCsvRowCommand
     *
     * @param BusinessRepository $repository An implementation of the BusinessRepository
     * @param Geocoder           $geocoder   Geocoder to get [lat, lng] of business
     */
    public function __construct(BusinessRepository $repository, Geocoder $geocoder)
    {
        $this->repository = $repository;
        $this->geocoder = $geocoder;
        $this->validator = new BusinessValidator();
    }

    /**
     * Handles the Command by importing a Business from a CSV row
     *
     * @param ImportFromHttpRequestCommand $command The command to handle
     *
     * @return Business
     *
     * @throws EntityNotFoundException, BusinessValidationException
     */
    public function handle(ImportFromHttpRequestCommand $command)
    {
        $data = $command->getData();

        $businessUid = $command->getBusinessUid();
        $isCreate = !(boolean) $businessUid;
        
        $business = $isCreate ? new Business() : $this->repository->get($businessUid);
        if (!$business) {
            throw new EntityNotFoundException();
        }

        $this->updateValues(
            $business, $data, [
            'name',
            'description',
            'address',
            'postcode',
            'city',
            'localArea',
            'mobile',
            'landline',
            'website',
            'warranty',
            'warrantyOffered',
            'positiveReviewPc',
            'reviewSource',
            'averageScore',
            'numberOfReviews'
            ]
        );

        $business->setGeolocation($this->geocoder->geocode($business->getAddress() . ', ' . $business->getPostcode()));

        $this->validator->validate($business);

        if ($isCreate) {
            $this->repository->add($business);
        }
        return $business;
    }

    /**
     * Update the $business fields from a $data array, using the $fields to index in to the $data and
     * to select the correct setter on the Business class.
     *
     * @param Business $business The business to update
     * @param array    $data     An [ $key => $value ] array of fields to update
     * @param array    $fields   An array of field names (strings) that should be updated
     *
     * @return void
     */
    private function updateValues($business, $data, $fields) 
    {
        foreach ($fields as $key) {
            if (array_key_exists($key, $data)) {
                $business->{'set' . ucfirst($key)}($data[$key]);
            }
        }
    }
}
