<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'dashboards' => [
            'menu' => [
                'Voting' => [
                    'path' => '/i_r_c_votes/dashboard',
                    'icon' => 'fa-check-square-o'
                ]
            ]
        ],
        'voting' => [
            'type' => 'group',
            'group' => 'Voting',
            'icon' => 'fa-check-square-o',
            'css'   => 'non-active',
            'menu' => [
                'Nominations' => [
                    'path' => '/i_r_c_votes/',
                    'icon' => 'fa-user-plus'
                ]
            ]
        ]
    ]
];

Sidebar::setMenu($menus);
