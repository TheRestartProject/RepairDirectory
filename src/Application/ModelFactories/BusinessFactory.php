<?php

namespace TheRestartProject\RepairDirectory\Application\ModelFactories;

use TheRestartProject\RepairDirectory\Domain\Enums\Cluster;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use UnexpectedValueException;

/**
 * Class BusinessFactory
 *
 * @category Factory
 * @package  TheRestartProject\RepairDirectory\Infrastructure\ModelFactories
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class BusinessFactory
{
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
    public function fromCsvRow($row)
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

        $addressParts = $this->splitUKAddress($row['Address']);

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

        $business->setProductsRepaired(array_map(function ($str) {
            return trim($str);
        }, explode(',', $row['Products repaired'])));

        $business->setQualifications($row['Qualifications']);

        $reviewUrl = $row['Independent review link'];
        $reviewSource = ReviewSource::derive($reviewUrl);
        if ($reviewSource) {
            $business->setReviewSource($reviewSource);
        }

        $business->setPositiveReviewPc((int)$row['Positive review %']);
        $business->setWarranty($row['Warranty offered']);
        $business->setWarrantyOffered((boolean)$business->getWarranty());
        $business->setPricingInformation($row['Pricing information']);
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
        return $value && $value !== 'no' && $value !== 'none';
    }

    /**
     * Parse a string representing an address into a keyed array with the structure:
     *
     * [
     *     'address' => $address,
     *     'city'    => $city,
     *     'postcode => $postcode
     * ]
     *
     * @param string $addressRow The address to parse
     *
     * @return array
     */
    private function splitUKAddress($addressRow)
    {
        $addressLines = explode(",", $addressRow);
        $addressLines = array_map(
            function ($item) {
                return trim($item);
            }, $addressLines
        );

        $lastLineWords = explode(" ", array_pop($addressLines));

        while (count($lastLineWords) > 2) {
            $addressLines[] = array_shift($lastLineWords);
        }

        $postcode = implode(" ", $lastLineWords);
        $city = array_pop($addressLines);
        $address = implode(", ", $addressLines);

        return [
            "address" => $address,
            "postcode" => $postcode,
            "city" => $city
        ];
    }
}
