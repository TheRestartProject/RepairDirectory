<?php

return [
    'TheRestartProject\Fixometer\Domain\Entities\User' => [
        'type'   => 'entity',
        'table'  => 'users',
        'id'     => [
            'uid' => [
                'type'     => 'integer',
                'column' => 'id',
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
            'username' => [
                'type' => 'string'
            ],
            'role' => [
                'type' => 'integer'
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
                'column' => 'updated_at',
                'nullable' => true
            ],
        ],
        'manyToOne' => [
            'repairDirectoryRole' => [
                'targetEntity' => 'Role',
                'joinColumn' => [
                    'name' => 'repairdir_role',
                    'referencedColumnName' => 'id',
                ]
            ]
        ],
    ],
    'TheRestartProject\Fixometer\Domain\Entities\FixometerSession' => [
        'type'   => 'entity',
        'table'  => 'sessions',
        'id'     => [
            'idsessions' => [
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
    ],
    'TheRestartProject\Fixometer\Domain\Entities\Role' => [
        'type'   => 'entity',
        'table' => 'repairdir_roles',
        'id' => [
            'uid' => [
                'type'     => 'integer',
                'column' => 'id',
                'generator' => [
                    'strategy' => 'auto'
                ]
            ],
        ],
        'fields' => [
            'name' => [
                'type' => 'string'
            ],
        ]
    ],
];
