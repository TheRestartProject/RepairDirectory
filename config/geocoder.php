<?php

/**
 * This file is part of the GeocoderLaravel library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Geocoder\Provider\Mapbox\Mapbox;
use Geocoder\Provider\Photon\Photon;

return [
    'cache-duraction' => 999999999,
    'providers' => [
        Mapbox::class => [
            env('MAPBOX_TOKEN'),
            'GB'
        ],
//        Photon::class => [
//            'https://photon.komoot.io/',
//        ]
    ]
];
