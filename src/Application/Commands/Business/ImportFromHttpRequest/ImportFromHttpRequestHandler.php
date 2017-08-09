<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;


use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Exceptions\EntityNotFoundException;
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
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
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
        if (array_key_exists('name', $data)) {
            $business->setName($data['name']);
        }
        if (array_key_exists('description', $data)) {
            $business->setDescription($data['description']);
        }
        if (array_key_exists('address', $data)) {
            $business->setAddress($data['address']);
        }
        if (array_key_exists('postcode', $data)) {
            $business->setPostcode($data['postcode']);
        }
        if (array_key_exists('category', $data)) {
            $business->setCategory($data['category']);
        }
        $business->setGeolocation($this->geocoder->geocode($business->getAddress() . ', ' . $business->getPostcode()));
        if ($isCreate) {
            $this->repository->add($business);
        }
        return $business;
    }
}
