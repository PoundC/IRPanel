<?php

require_once __DIR__ . '/menus.php';

use Cake\Core\Configure;

$permissions = \Cake\Core\Configure::read('MyPermissions');
$someMorePermissions = [
    [
        'role' => 'user',
        'plugin' => 'IRPanelVetting',
        'controller' => ['Vets'],
        'action' => ['nominations'],
    ]
];
$permissions = array_merge((array)$permissions, $someMorePermissions);
\Cake\Core\Configure::write('MyPermissions', $permissions);
