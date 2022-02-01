<?php
return [
    'birthday' => env('BOOM_BIRTHDAY'),
    'contributions' => [
        'domain' => [
            'cost' => env('BOOM_CONTRIBUTIONS_DOMAIN_COST'),
            'per' => env('BOOM_CONTRIBUTIONS_DOMAIN_PER'),
            'manual' => env('BOOM_CONTRIBUTIONS_DOMAIN_MANUAL')
        ],
        'hosting' => [
            'cost' => env('BOOM_CONTRIBUTIONS_HOSTING_COST'),
            'per' => env('BOOM_CONTRIBUTIONS_HOSTING_PER'),
            'manual' => env('BOOM_CONTRIBUTIONS_HOSTING_MANUAL')
        ],
        'coffee' => [
            'cost' => env('BOOM_CONTRIBUTIONS_COFFEE_COST'),
            'per' => env('BOOM_CONTRIBUTIONS_COFFEE_PER')
        ]
    ]
];
