<?php

return [
    'TheRestartProject\Fixometer\Domain\Entities\User' => [
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
    'TheRestartProject\Fixometer\Domain\Entities\FixometerSession' => [
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