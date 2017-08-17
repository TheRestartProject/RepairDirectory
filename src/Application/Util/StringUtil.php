<?php

namespace TheRestartProject\RepairDirectory\Application\Util;

class StringUtil {

    static function stringToArray($string) {
        return array_values(
            array_filter(
                array_map(function ($string) {
                    return trim($string);
                }, explode(',', $string))
            )
        );
    }
    
}