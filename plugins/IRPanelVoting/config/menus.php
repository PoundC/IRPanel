<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        /*'dashboards' => [
            'menu' => [
                'Voting' => [
                    'path' => '/voting/votes/dashboard',
                    'icon' => 'fa-check-square-o'
                ]
            ]
        ],*/
        'voting' => [
            'type' => 'group',
            'group' => 'Voting',
            'icon' => 'fa-check-square-o',
            'css'   => 'non-active',
            'menu' => [
                'Proposals' => [
                    'path' => '/voting/proposals',
                    'icon' => 'fa-user-secret'
                ],
                'Search' => [
                    'path' => '/voting/search',
                    'icon' => 'fa-search'
                ],/*
                'Create' => [
                    'path' => '/voting/create',
                    'icon' => 'fa-plus-square-o'
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
