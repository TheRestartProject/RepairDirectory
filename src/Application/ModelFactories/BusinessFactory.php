<?php

namespace TheRestartProject\RepairDirectory\Application\ModelFactories;

use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;

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

        $latLng = array_map(
            function ($str) {
                return (float) $str;
            },
            explode(',', $row['Geolocation'])
        );
        $business->setGeolocation(new Point($latLng[0], $latLng[1]));

        $addressParts = $this->splitUKAddress($row['Address']);

        $business->setPostcode($addressParts['postcode']);
        $business->setAddress($addressParts['address']);
        $business->setCity($addressParts['city']);
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

    private function splitUKAddress($addressRow)
    {
        $arr = explode("," ,  $addressRow);
        $arr = array_map( function ($item) { return trim($item);}, $arr);

        $last = explode(" " , array_pop($arr));

        if (count($last) > 2)
        {
       
            $postcode = $last[count($last) - 2] . end($last);
            $city = implode(" ", array_slice($last, 0, count($last - 2)));
            $address = implode(", ", $arr);

            return [
                "address" => $address,
                "postcode" => $postcode,
                "city" => $city
            ];
        }

            $postcode = implode(" ", $last);
            $city = array_pop($arr);
            $address = implode(", ", $arr);

        return [
            "address" => $address,
            "postcode" => $postcode,
            "city" => $city
        ];
    }
}
