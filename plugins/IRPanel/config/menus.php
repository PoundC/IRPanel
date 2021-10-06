<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        /*'dashboards' => [
            'type' => 'group',
            'group' => 'Dashboards',
            'icon' => 'fa-dashboard',
            'css'   => 'non-active',
            'menu' => [
                'Personal' => [
                    'path' => '/dashboard',
                    'icon' => 'fa-briefcase'
                ],
                'Relay Chat' => [
                    'path' => '/i_r_c_logs/dashboard',
                    'icon' => 'fa-comments',
                    'menu' => [
                        'Reports' => [
                            'path' => '/whoa',
                            'icon' => 'fa-search'
                        ]
                    ]
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
