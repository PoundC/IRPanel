<?php

return [
    'Users' => [
        'table' => 'users',
        // Controller used to manage users plugin features & actions
        'controller' => 'AdminLTE/Users',
        'Email' => [
            // determines if the user should include email
            'required' => true,
            // determines if registration workflow includes email validation
            'validate' => false,
        ]
    ],
];
