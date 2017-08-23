<?php

return [
    'public' => [
        [
            'field' => 'address',
            'operator' => '!=',
            'value' => ''
        ],
        [
            'field' => 'postcode',
            'operator' => '!=',
            'value' => ''
        ],
        [
            'field' => 'city',
            'operator' => '!=',
            'value' => ''
        ],
        [
            'field' => 'warrantyOffered',
            'operator' => '=',
            'value' => true
        ],
        [
            'field' => 'positiveReviewPc',
            'operator' => '>=',
            'value' => '80'
        ]
    ]
];