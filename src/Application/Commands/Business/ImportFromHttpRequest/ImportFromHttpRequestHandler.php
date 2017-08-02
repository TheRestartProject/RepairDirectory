<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;


use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\BusinessGeocoder;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;

/**
 * Handles the ImportFromCsvRowCommand to import a Business
 *
 * @category CommandHandler
 * @package  TheRestartProject\RepairDirectory\Application\Business\Handlers
 * @author   Matthew Kendon <matt@outlandish.com>
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
     * The factory to create the business with
     *
     * @var BusinessFactory
     */
    private $factory;

    /**
     * The geocoder to get [lat, lng] of business
     *
     * @var BusinessGeocoder
     */
    private $geocoder;

    /**
     * Creates the handler for the ImportBusinessFromCsvRowCommand
     *
     * @param BusinessRepository $repository An implementation of the BusinessRepository
     * @param BusinessFactory    $factory    Factory class to construct businesses
     * @param BusinessGeocoder           $geocoder   Geocoder to get [lat, lng] of business
     */
    public function __construct(BusinessRepository $repository, BusinessFactory $factory, BusinessGeocoder $geocoder)
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->geocoder = $geocoder;
    }

    /**
     * Handles the Command by importing a Business from a CSV row
     *
     * @param ImportFromHttpRequestCommand $command The command to handle
     *
     * @return Business
     */
    public function handle(ImportFromHttpRequestCommand $command)
    {
        $request = $command->getRequest();
        $businessUid = $command->getBusinessUid();
        $isCreate = !(boolean) $businessUid;
        $business = $isCreate ? new Business() : $this->repository->get($businessUid);
        $business->setName($request->input('name'));
        $business->setDescription($request->input('description'));
        $business->setAddress($request->input('address'));
        $business->setPostcode($request->input('postcode'));
        $business->setGeolocation($this->geocoder->geocode($business));
        if ($isCreate) {
            $this->repository->add($business);
        }
        return $business;
    }
}
