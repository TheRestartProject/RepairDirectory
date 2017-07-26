<?php
return [
    'TheRestartProject\RepairDirectory\Domain\Models\Business' => [
        'type'   => 'entity',
        'table'  => 'businesses',
        'id'     => [
            'id' => [
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
                'type' => 'string',
                'unique' => true
            ]
        ]
    ]
];