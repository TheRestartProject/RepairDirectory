<?php

/**
 * This file is part of the GeocoderLaravel library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Geocoder\Provider\GoogleMaps\GoogleMaps;

try {
    $config = new Platformsh\ConfigReader\Config();

    if (!$config->isValidPlatform()) {
        die("Not in a Platform.sh Environment.");
    }

    $api_key = $config->credentials('GOOGLE_MAPS_API_KEY');
} catch (Exception $e) {
    # This can happen during build phase.
    $api_key = '';
}


return [
    'cache-duraction' => 999999999,
    'providers' => [
        GoogleMaps::class => [
            null,
            $api_key,
        ],
    ]
];
