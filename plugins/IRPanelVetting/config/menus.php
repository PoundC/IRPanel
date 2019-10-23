<?php

use AdminLTE\Utility\Sidebar;

$menus = [
    'user' => [
        'voting' => [
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
