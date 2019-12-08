<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'dashboards' => [
            'menu' => [
                'Jams' => [
                    'path' => '/i_r_c_jams/jams/dashboard',
                    'icon' => 'fa-music'
                ]
            ]
        ],
        [
            'type' => 'group',
            'group' => 'Jams',
            'icon' => 'fa-music',
            'css'   => 'non-active',
            'menu' => [
                'Player' => [
                    'path' => '/i_r_c_jams/jams/player',
                    'icon' => 'fa-play-circle-o'
                ],
                'History' => [
                    'path' => '/i_r_c_jams/jams/history',
                    'icon' => 'fa-history'
                ],
                'Search' => [
                    'path' => '/i_r_c_jams/jams/search',
                    'icon' => 'fa-search'
                ]
            ]
        ]
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
