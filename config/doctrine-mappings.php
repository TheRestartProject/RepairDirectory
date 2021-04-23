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
            'reviewSourceUrl' => [
                'type' => 'string',
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
            ],
            'createdAt' => [
                'type' => 'datetime',
                'nullable' => true
            ],
            'updatedAt' => [
                'type' => 'datetime',
                'nullable' => true
            ],
            'createdBy' => [
                'type' => 'integer',
                'nullable' => true
            ],
            'updatedBy' => [
                'type' => 'integer',
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
    ],
    'TheRestartProject\RepairDirectory\Domain\Models\Submission' => [
        'type'   => 'entity',
        'table'  => 'submissions',
        'id'     => [
            'externalId' => [
                'type'     => 'string',
            ],
        ],
        'uniqueConstraints' => [
            [
                'name' => 'submission_unique_idx',
                'columns' => ['uid']
            ]
        ],
        'fields' => [
            'businessName' => [
                'type' => 'string'
            ],
            'businessWebsite' => [
                'type' => 'string'
            ],
            'businessBorough' => [
                'type' => 'string'
            ],
            'reviewSource' => [
                'type' => 'string'
            ],
            'extraInfo' => [
                'type' => 'string'
            ],
            'createdAt' => [
                'type' => 'datetime'
            ],
            'submittedByEmployee' => [
                'type' => 'boolean'
            ],
            'status' => [
                'type' => 'string',
                'columnDefinition' => "ENUM('added', 'duplicate', 'outside', 'spam', 'other')"
            ]
        ]
    ]
];
