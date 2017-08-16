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
        'uniqueConstraints' => [
            [
                'name' => 'business_unique_idx',
                'columns' => ['name', 'address']
            ]
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
            'city' => [
                'type' => 'string',
                'nullable' => true
            ],
            'geolocation' => [
                'type' => 'point',
                'nullable' => true
            ],
            'description' => [
                'type' => 'text'
            ],
            'landline' => [
                'type' => 'string',
                'nullable' => true
            ],
            'mobile' => [
                'type' => 'string',
                'nullable' => true
            ],
            'website' => [
                'type' => 'string',
                'nullable' => true
            ],
            'email' => [
                'type' => 'string',
                'nullable' => true
            ],
            'localArea' => [
                'type' => 'string',
                'nullable' => true
            ],
            'category' => [
                'type' => 'string',
                'nullable' => true
            ],
            'productsRepaired' => [
                'type' => 'array',
                'nullable' => true
            ],
            'authorised' => [
                'type' => 'boolean'
            ],
            'qualifications' => [
                'type' => 'string',
                'nullable' => true
            ],
            'reviews' => [
                'type' => 'array',
                'nullable' => true
            ],
            'positiveReviewPc' => [
                'type' => 'integer',
                'nullable' => true
            ],
            'warranty' => [
                'type' => 'text',
                'nullable' => true
            ],
            'pricingInformation' => [
                'type' => 'text',
                'nullable' => true
            ]
        ]
    ],
    'TheRestartProject\RepairDirectory\Domain\Models\Suggestion' => [
        'type'   => 'entity',
        'table'  => 'suggestions',
        'id'     => [
            'uid' => [
                'type'     => 'integer',
                'generator' => [
                    'strategy' => 'auto'
                ]
            ],
        ],
        'uniqueConstraints' => [
            [
                'name' => 'suggestion_unique_idx',
                'columns' => ['field', 'value']
            ]
        ],
        'fields' => [
            'field' => [
                'type' => 'string'
            ],
            'value' => [
                'type' => 'string'
            ]
        ]
    ]
];