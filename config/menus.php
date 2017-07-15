<?php

use App\Utility\Menu;

$menus = [
    'visitor' => [
        'Site Links' => [
            [
                'link'  => 'Click To Register Account',
                'icon'  => 'fa-pencil-square',
                'path'  => '/register'
            ],
            [
                'group' => 'Visitor Menu',
                'icon'  => 'fa-map-signs',
                'menu'  => [
                    'Home'          => [
                        'path' => '/',
                        'icon' => 'fa-home',
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
                        'icon' => 'fa-building'
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
                'group' => 'User Menu',
                'icon'  => 'fa-pencil',
                'menu' => [
                    'Home'  => [
                        'path'  => '/home',
                        'icon'  => 'fa-home'
                    ],
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
        'Company Links' => [
            [
                'group' => 'Support Menu',
                'icon'  => 'fa-support',
                'menu' => [
                    'Live Chat' => [
                        'path' => '/chat',
                        'icon' => 'fa-wechat'
                    ],
                    'Forum'     => [
                        'path' => '/forum',
                        'icon' => 'fa-comments'
                    ],
                    'Contact Us'=> [
                        'path' => '/contact',
                        'icon' => 'fa-comment'
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