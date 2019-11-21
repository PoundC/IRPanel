<?php

require_once __DIR__ . '/menus.php';

use Cake\Core\Configure;

$permissions = Configure::read('MyPermissions');
$someMorePermissions = [
    [
        'role' => ['user'],
        'plugin' => 'IRPanelMedia',
        'controller' => ['Media'],
        'action' => ['browse', 'search', 'view', 'dashboard', 'delete'],
        'allowed' => true,
    ]
];
$permissions = array_merge((array)$permissions, $someMorePermissions);
Configure::write('MyPermissions', $permissions);
