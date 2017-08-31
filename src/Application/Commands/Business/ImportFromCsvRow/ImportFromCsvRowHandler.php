<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow;


use TheRestartProject\RepairDirectory\Application\Util\AddressUtil;
use TheRestartProject\RepairDirectory\Application\Util\StringUtil;
use TheRestartProject\RepairDirectory\Domain\Enums\Cluster;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use UnexpectedValueException;

/**
 * Handles the ImportFromCsvRowCommand to import a Business
 *
 * @category CommandHandler
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromCsvRowHandler
{
    /**
     * An implementation of the BusinessRepository
     *
     * @var BusinessRepository
     */
    private $repository;

    /**
     * Creates the handler for the ImportBusinessFromCsvRowCommand
     *
     * @param BusinessRepository $repository An implementation of the BusinessRepository
     */
    public function __construct(BusinessRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handles the Command by importing a Business from a CSV row
     *
     * @param ImportFromCsvRowCommand $command The command to handle
     *
     * @return Business
     */
    public function handle(ImportFromCsvRowCommand $command)
    {
        $business = $this->fromCsvRow($command->getRow());
        $this->repository->add($business);
        return $business;
    }

    /**
     * Creates a Business from a CSV row that has been parsed
     * into an associative array.
     *
     * The keys of the array are the CSV column headers.
     *
     * @param array $row An associative array containing the row data
     *
     * @return Business
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function fromCsvRow($row)
    {
        $row = $this->trimKeysAndValues($row);

        $business = new Business();
        $business->setName($row['Name']);

        $latLng = array_map(
            function ($str) {
                return (float)$str;
            },
            explode(',', $row['Geolocation'])
        );
        $business->setGeolocation(new Point($latLng[0], $latLng[1]));

        $addressParts = AddressUtil::parseUKAddress($row['Address']);

        $business->setPostcode($addressParts['postcode']);
        $business->setAddress($addressParts['address']);
        $business->setCity($addressParts['city']);
        $business->setDescription($row['Description']);
        if ($this->isTruthy($row['Landline'])) {
            $business->setLandline($row['Landline']);
        }
        if ($this->isTruthy($row['Mobile'])) {
            $business->setMobile($row['Mobile']);
        }
        if ($this->isTruthy($row['Website'])) {
            $business->setWebsite($row['Website']);
        }
        if ($this->isTruthy($row['Email'])) {
            $business->setEmail($row['Email']);
        }
        $business->setLocalArea($row['Borough']);

        try {
            $cluster = new Cluster($row['Category']);
            $business->setCategories($cluster->getCategories());
        } catch (UnexpectedValueException $e) {
        }

        $business->setProductsRepaired(StringUtil::stringToArray($row['Products repaired']));

        $business->setQualifications($row['Qualifications']);

        $reviewUrl = $row['Independent review link'];
        $reviewSource = ReviewSource::derive($reviewUrl);
        if ($reviewSource) {
            $business->setReviewSource($reviewSource);
        }

        $business->setPositiveReviewPc((int)$row['Positive review %']);
        if ($this->isTruthy($row['Warranty offered'])) {
            $business->setWarranty($row['Warranty offered']);
        }
        $business->setWarrantyOffered((boolean)$business->getWarranty());
        $business->setPricingInformation($row['Pricing information']);
        $business->setPublishingStatus(PublishingStatus::PUBLISHED);
        return $business;
    }

    /**
     * Normalise the data in the row by trimming its keys and values
     *
     * @param array $row An associative array parsed from a row of CSV data
     *
     * @return array
     */
    private function trimKeysAndValues($row)
    {
        $newRow = [];
        foreach ($row as $key => $value) {
            $newRow[trim($key)] = trim($value);
        }
        return $newRow;
    }

    /**
     * Returns 'true' if $value is not empty and is not equal to 'no' or 'none'
     *
     * @param string $value The value to test
     *
     * @return bool
     */
    private function isTruthy($value)
    {
        $value = strtolower($value);
        return $value && $value !== 'no' && $value !== 'none' && $value !== 'no data';
    }
}
