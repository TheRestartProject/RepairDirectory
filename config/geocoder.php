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

return [
    'cache-duraction' => 999999999,
    'providers' => [
        GoogleMaps::class => [
            null,
            env('GOOGLE_MAPS_API_KEY'),
        ],
    ]
];
