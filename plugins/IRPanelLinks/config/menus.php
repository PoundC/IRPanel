<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'dashboards' => [
            'menu' => [
                'Links' => [
                    'path' => '/i_r_c_links/dashboard',
                    'icon' => 'fa-link'
                ]
            ]
        ],
        [
            'type' => 'group',
            'group' => 'Links',
            'icon' => 'fa-link',
            'css'   => 'non-active',
            'menu' => [
                'History' => [
                    'path' => '/i_r_c_links/links/browse',
                    'icon' => 'fa-dashboard'
                ],
                'Search' => [
                    'path' => '/i_r_c_links/links/search',
                    'icon' => 'fa-search'
                ],/*
                'Add' => [
                    'path' => '/i_r_c_media/add',
                    'icon' => 'fa-plus-circle'
                ]*/
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
