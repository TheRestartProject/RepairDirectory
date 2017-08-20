<?php

namespace TheRestartProject\RepairDirectory\Application\Util;

/**
 * Class AddressUtil. Functions that operate on addresses.
 *
 * @category Util
 * @package  TheRestartProject\RepairDirectory\Application\Util\StringUtil
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class AddressUtil {

    /**
     * Parse a string representing an address into a keyed array with the structure:
     *
     * [
     *     'address' => $address,
     *     'city'    => $city,
     *     'postcode => $postcode
     * ]
     *
     * @param string $addressStr The address to parse
     *
     * @return array
     */
    public static function parseUKAddress($addressStr) {
        $addressLines = explode(",", $addressStr);
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