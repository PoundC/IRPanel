<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'dashboards' => [
            'menu' => [
                'Quotes' => [
                    'path' => '/i_r_c_quotes/dashboard',
                    'icon' => 'fa-quote-right'
                ]
            ]
        ],
        'quotes' => [
            'type' => 'group',
            'group' => 'Quotes',
            'icon' => 'fa-quote-right',
            'css'   => 'non-active',
            'menu' => [
                'Search' => [
                    'path' => '/i_r_c_quotes/search',
                    'icon' => 'fa-search'
                ],
                'Browse' => [
                    'path' => '/i_r_c_quotes',
                    'icon' => 'fa-crosshairs'
                ],
                'Add' => [
                    'path' => '/i_r_c_quotes/add',
                    'icon' => 'fa-plus-square'
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
