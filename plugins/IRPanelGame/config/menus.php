<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        /*'dashboards' => [
            'menu' => [
                'The Game' => [
                    'path' => '/i_r_c_game/dashboard',
                    'icon' => 'fa-bomb'
                ]
            ]
        ],
        [
            'type' => 'group',
            'group' => 'The Game',
            'icon' => 'fa-bomb',
            'css'   => 'non-active',
            'menu' => [
                'Play' => [
                    'path' => '/i_r_c_game/play',
                    'icon' => 'fa-gamepad'
                ],
                'Labs' => [
                    'path' => '/i_r_c_game/lab',
                    'icon' => 'fa-flask'
                ],
                'Jobs' => [
                    'path' => '/i_r_c_game/jobs',
                    'icon' => 'fa-hourglass-2',

                     'path' => '#',
                     'menu' => [
                        'Create' => [
                            'path' => '/i_r_c_game/jobs/create',
                            'icon' => 'fa-plus'
                        ],
                        'Browse' => [
                            'path' => '/i_r_c_game/jobs',
                            'icon' => 'fa-map-o'
                        ],
                        'Search' => [
                            'path' => '/i_r_c_game/jobs/search',
                            'icon' => 'fa-search'
                        ],
                    ]
                ],
                'Items' => [
                    'path' => '/i_r_c_game/items',
                    'icon' => 'fa-bolt'
                ],
                'Animals' => [
                    'path' => '/i_r_c_game/animals',
                    'icon' => 'fa-ra'
                ],
                'People' => [
                    'path' => '/i_r_c_game/people',
                    'icon' => 'fa-users'
                ],
                'Objects' => [
                    'path' => '/i_r_c_game/objects',
                    'icon' => 'fa-gift'
                ],
                'Property' => [
                    'path' => '/i_r_c_game/property',
                    'icon' => 'fa-automobile'
                ]
            ]
        ]*/
    ],
    'superuser' => [
        /*
        [
            'type'  => 'group',
            'group' => 'Support Menu',
            'icon'  => 'fa-support',
            'css'   => 'active non-active',
            'menu' => [
                'Help & FAQ' => [
                    'path' => '/help',
                    'icon' => 'fa-question-circle'
                ],
                'View Chats' => [
                    'path' => '/openchats',
                    'icon' => 'fa-wechat'
                ],
                'View Tickets'     => [
                    'path' => '/tickets',
                    'icon' => 'fa-folder-open'
                ]
            ]
        ]
        */
    ]
];

Sidebar::setMenu($menus);
