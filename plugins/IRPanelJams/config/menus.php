<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'dashboards' => [
            'menu' => [
                'Jams' => [
                    'path' => '/i_r_c_jams/dashboard',
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
                'Dashboard' => [
                    'path' => '/quotes/dashboard',
                    'icon' => 'fa-dashboard'
                ],
                'Search' => [
                    'path' => '/quotes/search',
                    'icon' => 'fa-search'
                ],
                'Add' => [
                    'path' => '/quotes/add',
                    'icon' => 'fa-search'
                ]
            ]
        ]
    ],
    'superuser' => [
        [
            'type'  => 'header',
            'header' => 'Welcome Admin'
        ],
        [
            'type'  => 'group',
            'group' => 'Admin Menu',
            'icon'  => 'fa-user',
            'css'   => 'active non-active',
            'menu' => [
                'Dashboard' => [
                    'path' => '/dashboard',
                    'icon' => 'fa-dashboard',
                    /*
                    'menu' => [
                        'Reporting' => [
                            'path' => '/dashboard/reporting',
                            'icon' => 'fa-dashboard',
                            'menu' => [
                                'Reporting 2' => [
                                    'path' => '/dashboard/reporting/2',
                                    'icon' => 'fa-dashboard'
                                ]
                            ]
                        ]
                    ]
                    */
                ],
                'Search Users' => [
                    'path'  => '/search/users',
                    'icon'  => 'fa-search'
                ],
                'View Users' => [
                    'path'  => '/admin/users',
                    'icon'  => 'fa-users'
                ]
            ]
        ],
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
    ]
];

Sidebar::setMenu($menus);
