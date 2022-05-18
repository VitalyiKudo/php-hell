<?php

return [
    'active' => [
        'Not activated' => 0,
        'Active' => 1,
        'On hold' => 2,
        'Done' => 3,
        'Deleted' => 4,
    ],

    'active_bg' => [
        'bg-secondary' => 0,
        'bg-danger' => 1,
        'bg-warning' => 2,
        'bg-success' => 3,
        'bg-info' => 4,
    ],

    'plane' => [
        'type_plane' => [
            'plane_turbo' => [
                'type' =>'plane Turbo',
                'feature_plane' => [
                    'Passengers' => '1-12',
                    'Cubic feet' => '28',
                    'Altitude' => '30,000ft',
                    'Pilots' => '2',
                    'Range' => '3700 miles',
                    'Max Speed' => '534 mph',
                    'Flight Time' => '-',
                ]
            ],
            'plane_light' => [
                'type' =>'plane Light',
                'feature_plane' => [
                    'Passengers' => '1-8',
                    'Cubic feet' => '45',
                    'Altitude' => '37,000ft',
                    'Pilots' => '1-2',
                    'Range' => '2500 miles',
                    'Max Speed' => '360 mph',
                    'Flight Time' => '-',
                ]
            ],
            'plane_medium' => [
                'type' =>'plane Medium',
                'feature_plane' => [
                    'Passengers' => '1-11',
                    'Cubic feet' => '125',
                    'Altitude' => '51,000ft',
                    'Pilots' => '2',
                    'Range' => '4000 miles',
                    'Max Speed' => '603 mph',
                    'Flight Time' => '-',
                ]
            ],
            'plane_heavy' => [
                'type' =>'plane Heavy',
                'feature_plane' => [
                    'Passengers' => '1-16',
                    'Cubic feet' => '226',
                    'Altitude' => '41,000ft',
                    'Pilots' => '2',
                    'Range' => '8000 miles',
                    'Max Speed' => '562 mph',
                    'Flight Time' => '-',
                ]
            ],
        ],
        'icons' => [
            'Passengers' => 'images/passagers.svg',
            'Cubic feet' => 'images/max_bags.svg',
            'Altitude' => 'images/altitude.svg',
            'Pilots' => 'images/pilots.svg',
            'Range' => 'images/range.svg',
            'Max Speed' => 'images/mas_speed.svg',
            'Flight Time' => 'images/time.svg',
        ]
    ],
];
