<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'visitor' => [
        [
            'type'  => 'header',
            'header' => 'Welcome to PoundC'
        ],
        [
            'type'  => 'link',
            'link'  => 'Click To Register',
            'icon'  => 'fa-pencil-square',
            'path'  => '/register'
        ],
        [
            'type'  => 'group',
            'group' => 'Visitor Menu',
            'icon'  => 'fa-map',
            'css'   => 'active non-active',
            'menu'  => [
                'Home' => [
                    'path' => '/',
                    'icon' => 'fa-home',
                ],
                'Products' => [
                    'path' => '/products',
                    'icon' => 'fa-binoculars'
                ],
                'Pricing' => [
                    'path' => '/pricing',
                    'icon' => 'fa-money',
                ],
                'About' => [
                    'path' => '/about',
                    'icon' => 'fa-flag'
                ],
                'Company' => [
                    'path' => '/company',
                    'icon' => 'fa-cogs'
                ],
                'Investors' => [
                    'path' => '/investors',
                    'icon' => 'fa-line-chart'
                ],
            ]
        ],
        [
            'type'  => 'group',
            'group' => 'User Menu',
            'icon'  => 'fa-user',
            'css'   => 'active non-active',
            'menu'  => [
                'Login'          => [
                    'path' => '/login',
                    'icon' => 'fa-sign-in',
                ],
                'Reset Password' => [
                    'path' => '/reset',
                    'icon' => 'fa-compass',
                ]
            ]
        ]

    ],
    'user' => [
        [
            'type'  => 'header',
            'header' => 'Welcome User'
        ],
        /*[
            'type'  => 'link',
            'link'  => 'Upgrade to Member',
            'icon'  => 'fa-rocket',
            'path'  => '/profile'
        ],*/
        [
            'type'  => 'link',
            'link'  => 'Dashboard',
            'icon'  => 'fa-dashboard',
            'path'  => '/dashboard'
        ],
        [
            'type'  => 'link',
            'link'  => 'Notifications',
            'icon'  => 'fa-bell-o',
            'path'  => '/notifications'
        ],
        [
            'type'  => 'link',
            'link'  => 'Messages',
            'icon'  => 'fa-envelope-o',
            'path'  => '/messages'
        ],
        [
            'type'  => 'link',
            'link'  => 'Pending Tasks',
            'icon'  => 'fa-flag-checkered',
            'path'  => '/tasks'
        ]
    ],
    'member' => [
        [
            'type'  => 'header',
            'header' => 'Welcome Member'
        ],
        [
            'type'  => 'link',
            'link'  => 'Dashboard',
            'icon'  => 'fa-dashboard',
            'path'  => '/dashboard'
        ],
        [
            'type'  => 'link',
            'link'  => 'Notifications',
            'icon'  => 'fa-bell-o',
            'path'  => '/notifications'
        ],
        [
            'type'  => 'link',
            'link'  => 'Messages',
            'icon'  => 'fa-envelope-o',
            'path'  => '/messages'
        ],
        [
            'type'  => 'link',
            'link'  => 'Pending Tasks',
            'icon'  => 'fa-flag-checkered',
            'path'  => '/tasks'
        ]
    ],
    'superuser' => [
        [
            'type'  => 'header',
            'header' => 'Welcome Admin'
        ],
        [
            'type'  => 'link',
            'link'  => 'Notifications',
            'icon'  => 'fa-bell-o',
            'path'  => '/notifications'
        ],
        [
            'type'  => 'link',
            'link'  => 'Messages',
            'icon'  => 'fa-envelope-o',
            'path'  => '/messages'
        ],
        [
            'type'  => 'link',
            'link'  => 'Pending Tasks',
            'icon'  => 'fa-flag-checkered',
            'path'  => '/tasks'
        ],
        [
            'type'  => 'group',
            'group' => 'Admin Menu',
            'icon'  => 'fa-user',
            'css'   => 'non-active',
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
            'group' => 'Support',
            'icon'  => 'fa-support',
            'css'   => 'non-active',
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
    ],
    'site' => [
        [
            'type'  => 'link',
            'link' => 'Help & FAQ',
            'path' => '/help',
            'icon' => 'fa-question-circle'
        ],
        [
            'type'  => 'link',
            'link'  => 'Contact Us',
            'icon'  => 'fa-bullhorn',
            'path'  => '/contact'
        ]
    ]
];

Sidebar::setMenu($menus);
