<?php

use App\Utility\Menu;

$menus = [
    'visitor' => [
        'Welcome to CakeAdminLTE' => [
            [
                'link'  => 'Click To Register',
                'icon'  => 'fa-pencil-square',
                'path'  => '/register'
            ],
            [
                'group' => 'Visitor Menu',
                'icon'  => 'fa-map-signs',
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
                        'icon' => 'fa-dollar',
                    ],
                    'FAQ'   => [
                        'path' => '/faq',
                        'icon' => 'fa-question-circle'
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
                        'icon' => 'fa-money'
                    ],
                ]
            ],
            [
                'group' => 'User Menu',
                'icon'  => 'fa-child',
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
        ]
    ],
    'user' => [
        'User Links' => [
            [
                'link'  => 'Click to Upgrade',
                'icon'  => 'fa-fighter-jet',
                'path'  => '/upgrade'
            ],
            [
                'group' => 'User Menu',
                'icon'  => 'fa-pencil',
                'css'   => 'active non-active',
                'menu' => [
                    'Dashboard' => [
                        'path' => '/dashboard',
                        'icon' => 'fa-dashboard'
                    ],
                    'Profile' => [
                        'path' => '/profile',
                        'icon' => 'fa-briefcase',
                    ],
                    'Logout' =>[
                        'path' => '/logout',
                        'icon' => 'fa-sign-out',
                    ]
                ]
            ]
        ]
    ],
    'site' => [
        'Sitewide Links' => [
            [
                'group' => 'Support Menu',
                'icon'  => 'fa-support',
                'css'   => 'active non-active',
                'menu' => [
                    'Live Group Chat' => [
                        'path' => '/chat',
                        'icon' => 'fa-wechat'
                    ],
                    'Open Support Ticket'     => [
                        'path' => '/forum',
                        'icon' => 'fa-ticket'
                    ]

                    // Placeholder for Example Tiered Menus
                    /*
                    [
                        'group' => 'Page 2',
                        'icon'  => 'fa-exchange',
                        'menu' => [
                            'Link Level 2' => [
                                'path' => '/link_level_2',
                                'icon' => 'fa-pencil'
                            ],
                            [
                                'group' => 'Page 3',
                                'icon'  => 'fa-pencil',
                                'menu' => [
                                    'Link Level 3' => [
                                        'path' => '/login',
                                        'icon' => 'fa-pencil'
                                    ]
                                ]
                            ]
                        ]
                    ]
                    */
                ]
            ]
        ]
    ]
];

Menu::setAll($menus);