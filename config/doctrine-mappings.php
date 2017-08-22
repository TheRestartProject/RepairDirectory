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
            'categories' => [
                'type' => 'array'
            ],
            'productsRepaired' => [
                'type' => 'array'
            ],
            'authorisedBrands' => [
                'type' => 'array'
            ],
            'communityEndorsement' => [
                'type' => 'string',
                'nullable' => true
            ],
            'notes' => [
                'type' => 'string',
                'nullable' => true
            ],
            'qualifications' => [
                'type' => 'string',
                'nullable' => true
            ],
            'positiveReviewPc' => [
                'type' => 'integer',
                'nullable' => true
            ],
            'reviewSource' => [
                'type' => 'string',
                'nullable' => true
            ],
            'averageScore' => [
                'type' => 'float',
                'nullable' => true
            ],
            'numberOfReviews' => [
                'type' => 'integer',
                'nullable' => true
            ],
            'warranty' => [
                'type' => 'text',
                'nullable' => true
            ],
            'warrantyOffered' => [
                'type' => 'boolean',
                'nullable' => true
            ],
            'pricingInformation' => [
                'type' => 'text',
                'nullable' => true
            ],
            'publishingStatus' => [
                'type' => 'string',
                'nullable' => false
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
    ],
    'TheRestartProject\RepairDirectory\Domain\Models\User' => [
        'type'   => 'entity',
        'table'  => 'users',
        'id'     => [
            'uid' => [
                'type'     => 'integer',
                'column' => 'idusers',
                'generator' => [
                    'strategy' => 'auto'
                ]
            ],
        ],
        'uniqueConstraints' => [
            [
                'name' => 'email_UNIQUE',
                'columns' => ['email']
            ]
        ],
        'fields' => [
            'email' => [
                'type' => 'string'
            ],
            'password' => [
                'type' => 'string',
                'length' => 60
            ],
            'name' => [
                'type' => 'string'
            ],
            'recovery' => [
                'type' => 'string',
                'length' => 45,
                'nullable' => true
            ],
            'recoveryExpires' => [
                'type' => 'datetime',
                'column' => 'recovery_expires',
                'nullable' => true
            ],
            'createdAt' => [
                'type' => 'datetime',
                'column' => 'created_at',
                'nullable' => true
            ],
            'modifiedAt' => [
                'type' => 'datetime',
                'column' => 'modified_at',
                'nullable' => true
            ]
        ]
    ],
    'TheRestartProject\RepairDirectory\Domain\Models\FixometerSession' => [
        'type'   => 'entity',
        'table'  => 'sessions',
        'id'     => [
            'idsession' => [
                'type'     => 'integer',
                'generator' => [
                    'strategy' => 'auto'
                ]
            ],
        ],
        'uniqueConstraints' => [
            [
                'name' => 'session_unique_idx',
                'columns' => ['session']
            ]
        ],
        'fields' => [
            'session' => [
                'type' => 'string'
            ],
            'user' => [
                'type' => 'integer'
            ],
            'createdAt' => [
                'type' => 'datetime',
                'column' => 'created_at'
            ],
            'modifiedAt' => [
                'type' => 'datetime',
                'column' => 'modified_at'
            ]
        ]
    ]
];