<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'dashboards' => [
            'menu' => [
                'Quotes' => [
                    'path' => '/quotes/dashboard',
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
                    'path' => '/quotes/search',
                    'icon' => 'fa-search'
                ],
                'Browse' => [
                    'path' => '/quotes/browse',
                    'icon' => 'fa-crosshairs'
                ],
                /*'Add' => [
                    'path' => '/quotes/add',
                    'icon' => 'fa-plus-square'
                ]*/
            ]
        ]
    ],
    'superuser' => [
        'dashboards' => [
            'menu' => [
                'Quotes' => [
                    'path' => '/quotes/admin_dashboard',
                    'icon' => 'fa-quote-right'
                ]
            ]
        ]
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
