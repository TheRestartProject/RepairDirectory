<?php

use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;

return [
    'public' => [
        [
            'field' => 'address',
            'operator' => Operators::NOT_EQUAL,
            'value' => ''
        ],
        [
            'field' => 'postcode',
            'operator' => Operators::NOT_EQUAL,
            'value' => ''
        ],
        [
            'field' => 'city',
            'operator' => Operators::NOT_EQUAL,
            'value' => ''
        ],
        [
            'field' => 'warrantyOffered',
            'operator' => Operators::EQUAL,
            'value' => true
        ],
        [
            'field' => 'positiveReviewPc',
            'operator' => Operators::GREATER_THAN_OR_EQUAL,
            'value' => '80'
        ],
        [
            'field' => 'publishingStatus',
            'operator' => Operators::EQUAL,
            'value' => PublishingStatus::PUBLISHED
        ]
    ]
];