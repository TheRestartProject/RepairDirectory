<?php
return [
    'TheRestartProject\RepairDirectory\Domain\Models\Business' => [
        'type'   => 'entity',
        'table'  => 'businesses',
        'id'     => [
            'uid' => [
                'type'     => 'integer',
                'generator' => [
                    'strategy' => 'auto'
                ]
            ],
        ],
        'fields' => [
            'name' => [
                'type' => 'string'
            ],
            'address' => [
                'type' => 'string'
            ],
            'postcode' => [
                'type' => 'string'
            ],
            'geolocation' => [
                'type' => 'array'
            ],
            'description' => [
                'type' => 'text'
            ],
            'landline' => [
                'type' => 'string'
            ],
            'mobile' => [
                'type' => 'string'
            ],
            'website' => [
                'type' => 'string'
            ],
            'email' => [
                'type' => 'string'
            ],
            'localArea' => [
                'type' => 'string'
            ],
            'category' => [
                'type' => 'string'
            ],
            'productsRepaired' => [
                'type' => 'array'
            ],
            'authorised' => [
                'type' => 'boolean'
            ],
            'qualifications' => [
                'type' => 'string'
            ],
            'reviews' => [
                'type' => 'array'
            ],
            'positiveReviewPc' => [
                'type' => 'integer'
            ],
            'warranty' => [
                'type' => 'text'
            ],
            'pricingInformation' => [
                'type' => 'text'
            ]
        ]
    ]
];