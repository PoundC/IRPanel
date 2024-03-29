<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 * IMPORTANT:
 * This is an example configuration file. Copy this file into your config directory and edit to
 * setup your app permissions.
 *
 * This is a quick roles-permissions implementation
 * Rules are evaluated top-down, first matching rule will apply
 * Each line define
 *      [
 *          'role' => 'role' | ['roles'] | '*'
 *          'prefix' => 'Prefix' | , (default = null)
 *          'plugin' => 'Plugin' | , (default = null)
 *          'controller' => 'Controller' | ['Controllers'] | '*',
 *          'action' => 'action' | ['actions'] | '*',
 *          'allowed' => true | false | callback (default = true)
 *      ]
 * You could use '*' to match anything
 * 'allowed' will be considered true if not defined. It allows a callable to manage complex
 * permissions, like this
 * 'allowed' => function (array $user, $role, Request $request) {}
 *
 * Example, using allowed callable to define permissions only for the owner of the Posts to edit/delete
 *
 * (remember to add the 'uses' at the top of the permissions.php file for Hash, TableRegistry and Request
   [
        'role' => ['user'],
        'controller' => ['Posts'],
        'action' => ['edit', 'delete'],
        'allowed' => function(array $user, $role, Request $request) {
            $postId = Hash::get($request->params, 'pass.0');
            $post = TableRegistry::get('Posts')->get($postId);
            $userId = Hash::get($user, 'id');
            if (!empty($post->user_id) && !empty($userId)) {
                return $post->user_id === $userId;
            }
            return false;
        }
    ],
 */

$permissions = [
        [
            'role' => '*',
            'controller' => ['Pages'],
            'action' => ['display', 'other', 'index'],
            'allowed' => true,
        ],
        [
            'role' => '*',
            'controller' => ['Users'],
            'action' => ['login'],
            'allowed' => true,
        ],
        [
            'role' => '*',
            'controller' => ['Support'],
            'action' => ['contact'],
            'allowed' => true,
        ],
        [
            'role' => '*',
            'controller' => ['Help'],
            'action' => ['help'],
            'allowed' => true,
        ],
        [
            'role' => '*',
            'controller' => ['Visitors'],
            'action' => ['frontpage', 'products', 'pricing', 'faq', 'about', 'company', 'investors'],
            'allowed' => true,
        ],
        [
            'role' => '*',
            'controller' => ['Billing'],
            'action' => ['subscribe'],
            'allowed' => true,
        ],
        [
            'role' => ['member'],
            'plugin' => 'AdminLTE',
            'controller' => ['Billing'],
            'action' => ['cancel'],
            'allowed' => true,
        ],
        [
            'role' => ['user', 'member', 'admin'],
            'controller' => ['Chat'],
            'action' => ['online', 'chatsend', 'receive'],
            'allowed' => true,
        ],
        [
            'role' => '*',
            'controller' => ['Help'],
            'action' => ['help', 'faq', 'topic', 'tag', 'markdown'],
            'allowed' => true,
        ],
        [
            'role' => ['admin'],
            'controller' => ['Help'],
            'action' => ['senduser', 'convert', 'markdownfaq'],
            'allowed' => true,
        ],
        [
            'role' => ['admin'],
            'controller' => ['Support'],
            'action' => ['sendticket'],
            'allowed' => true,
        ],
        [
            'role' => ['admin'],
            'controller' => ['Chat'],
            'action' => ['openchats'],
            'allowed' => true,
        ],
        [
            'role' => ['admin'],
            'controller' => ['Search'],
            'action' => ['users'],
            'allowed' => true,
        ],
        [
            'role' => ['user', 'member', 'admin'],
            'controller' => ['Support'],
            'action' => ['open', 'tickets', 'view', 'reply', 'support', 'close'],
            'allowed' => true,
        ],
        [
            'role' => ['user', 'member', 'admin'],
            'controller' => 'Users',
            'action' => ['profile', 'oauth2callback'],
            'allowed' => true,
        ],
        [
            'role' => ['user', 'member', 'admin'],
            'controller' => 'Members',
            'action' => ['dashboard'],
            'allowed' => true,
        ],
        [
            'role' => ['admin'],
            'controller' => 'Users',
            'action' => ['index', 'view', 'edit', 'changePassword', 'avatar'],
            'allowed' => true,
        ],
        [
            'role' => 'user',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ['register', 'edit', 'view', 'logout'],
            'allowed' => true,
        ],
        [
            'role' => 'user',
            'plugin' => 'AdminLTE',
            'controller' => 'Users',
            'action' => ['edit', 'avatar'],
            'allowed' => true,
        ],
        [
            'role' => '*',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => 'resetGoogleAuthenticator',
            'allowed' => function (array $user, $role, \Cake\Http\ServerRequest $request) {
                $userId = \Cake\Utility\Hash::get($request->getAttribute('params'), 'pass.0');
                if (!empty($userId) && !empty($user)) {
                    return $userId === $user['id'];
                }

                return false;
            }
        ],
        [
            'role' => 'user',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => '*',
            'allowed' => false,
        ],
        [
            'role' => ['user'],
            'controller' => ['User'],
            'action' => ['search'],
            'allowed' => true,
        ]
    ];


$morePermissions = \Cake\Core\Configure::read('MyPermissions');
if(is_array($morePermissions)) {

    $allPerms = array_merge($permissions, $morePermissions);

    return ['CakeDC/Auth.permissions' => $allPerms];
}
else {

    return ['CakeDC/Auth.permissions' => $permissions];;
}
