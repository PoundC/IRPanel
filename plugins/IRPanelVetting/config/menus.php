<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'voting' => [
            'menu' => [
                'Nominations' => [
                    'path' => '/voting/nominations',
                    'icon' => 'fa-user-plus'
                ]
            ]
        ]
    ]
];

Sidebar::setMenu($menus);
