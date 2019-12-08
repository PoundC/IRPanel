<?php

require_once __DIR__ . '/menus.php';

use Cake\Core\Configure;

$permissions = Configure::read('MyPermissions');
$someMorePermissions = [
    [
        'role' => ['user'],
        'plugin' => 'IRPanelJams',
        'controller' => ['Jams'],
        'action' => ['player', 'search', 'history', 'dashboard', 'delete', 'ajaxPlayer', 'ajaxPlayed'],
        'allowed' => true,
    ]
];
$permissions = array_merge((array)$permissions, $someMorePermissions);
Configure::write('MyPermissions', $permissions);
