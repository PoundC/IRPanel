<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
       /* 'dashboards' => [
            'menu' => [
                'Media' => [
                    'path' => '/i_r_c_media/media/dashboard',
                    'icon' => 'fa-video-camera'
                ]
            ]
        ],*/
        [
            'type' => 'group',
            'group' => 'Media',
            'icon' => 'fa-video-camera',
            'css'   => 'non-active',
            'menu' => [
                'Browse' => [
                    'path' => '/i_r_c_media/media/browse',
                    'icon' => 'fa-crosshairs'
                ],
                'Search' => [
                    'path' => '/i_r_c_media/media/search',
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
