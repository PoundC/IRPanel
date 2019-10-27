<?php

require_once __DIR__ . '/menus.php';

use Cake\Core\Configure;

$permissions = Configure::read('MyPermissions');
$someMorePermissions = [
    [
        'role' => ['user'],
        'plugin' => 'IRPanelQuotes',
        'controller' => ['Quotes'],
        'action' => ['search', 'browse', 'add', 'view', 'dashboard'],
        'allowed' => true,
    ]
];
$permissions = array_merge((array)$permissions, $someMorePermissions);
Configure::write('MyPermissions', $permissions);
