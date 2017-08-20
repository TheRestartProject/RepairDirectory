<?php

namespace TheRestartProject\RepairDirectory\Application\Util;

/**
 * Class StringUtil. Functions that operate on strings.
 *
 * @category Util
 * @package  TheRestartProject\RepairDirectory\Application\Util\StringUtil
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class StringUtil
{

    /**
     * Convert a comma separated string into an array, trimming each value
     *
     * @param string $string A comma separated string
     * 
     * @return array
     */
    static function stringToArray($string) 
    {
        return array_values(
            array_filter(
                array_map(
                    function ($string) {
                        return trim($string);
                    }, explode(',', $string)
                )
            )
        );
    }
    
}
