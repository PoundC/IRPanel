<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;

$permissions = Configure::read('MyPermissions');
$someMorePermissions = [
    [
        'role' => ['user'],
        'plugin' => 'AdminLTE',
        'controller' => ['Messaging'],
        'action' => ['messageDelete', 'index', 'view', 'compose', 'toAutocomplete', 'sendReply'],
        'allowed' => true,
    ],
    [
        'role' => ['user'],
        'plugin' => 'AdminLTE',
        'controller' => ['Notifications'],
        'action' => ['index', 'view', 'growl'],
        'allowed' => true,
    ],
    [
        'role' => ['user'],
        'plugin' => 'AdminLTE',
        'controller' => ['Tasks'],
        'action' => ['index', 'delete'],
        'allowed' => true
    ]
];
$permissions = array_merge((array)$permissions, $someMorePermissions);
Configure::write('MyPermissions', $permissions);

Configure::write('Users.config', ['users']);
Plugin::load('CakeDC/Users', ['routes' => false, 'bootstrap' => true]);
