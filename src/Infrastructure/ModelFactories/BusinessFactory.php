<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\ModelFactories;

use TheRestartProject\RepairDirectory\Domain\Models\Business;

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
     */
    public function fromCsvRow($row)
    {
        $row = $this->trimKeysAndValues($row);

        $business = new Business();
        $business->setName($row['Name']);
        $business->setGeolocation(
            array_map(
                function ($str) {
                    return (float) $str;
                },
                explode(',', $row['Geolocation'])
            )
        );

        $addressParts = explode(',', $row['Address']);
        $business->setPostcode(trim(array_pop($addressParts)));
        $business->setAddress(implode(',', $addressParts));
        $business->setDescription($row['Description']);
        $business->setLandline($row['Landline']);
        $business->setMobile($row['Mobile']);
        $business->setWebsite($row['Website']);
        $business->setEmail($row['Email']);
        $business->setLocalArea($row['Borough']);
        $business->setCategory($row['Category']);
        $business->setProductsRepaired(explode(',', $row['Products repaired']));
        $business->setAuthorised($row['Authorised repairer'] === 'Yes');
        $business->setQualifications($row['Qualifications']);

        $reviews = [$row['Independent review link'], $row['Other review link']];
        $business->setReviews(array_filter($reviews));

        $business->setPositiveReviewPc((int) $row['Positive review %']);
        $business->setWarranty($row['Warranty offered']);
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
}
