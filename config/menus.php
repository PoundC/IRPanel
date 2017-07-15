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
                'group' => 'User Menu',
                'icon'  => 'fa-pencil',
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
                        'path'  => '/',
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
                        'icon' => 'fa-comment-o'
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