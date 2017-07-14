<?php

use App\Utility\Menu;

$menus = [
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
                ]
            ]
        ]
    ],
    'visitor' => [
        'Site Links' => [
            [
                'group' => 'Visitor Menu',
                'icon'  => 'fa-pencil',
                'menu' => [
                    'Login' =>[
                        'path' => '/login',
                        'icon' => 'fa-sign-in',
                    ],
                    'Register' => [
                        'path' => '/register',
                        'icon' => 'fa-pencil-square',
                    ],
                    'Reset Password' => [
                        'path' => '/reset_password',
                        'icon' => 'fa-compass',
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
            // Placeholder for Example Second Menu Group
            /*
            [
                'group' => 'Second Menu',
                'icon'  => 'fa-fighter-jet',
                'menu'  => [
                    'Silos' => [
                        'path' => '/drop_bombs',
                        'icon' => 'fa-bomb'
                    ]
                ]
            ]
            */
        ]
    ],
    'user' => [
        'User Links' => [
            'Home' => [
                'Dashboard' => [
                    'path' => '/dashboard',
                    'icon' => 'fa-dashboard'
                ],
                'Profile' => [
                    'path' => '/profile',
                    'icon' => 'fa-briefcase',
                ],
                'Logout' =>[
                    'path' => '/login',
                    'icon' => 'fa-sign-out',
                ]
            ]
        ]
    ]
];

Menu::setAll($menus);