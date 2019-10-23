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
