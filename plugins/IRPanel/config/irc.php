<?php

use \Cake\Core\Configure;

\Cake\Core\Configure::write(
    'networks', [
        'PoundC' => [
            'server' => 'irc.poundc.com',
            'port' => 6697,
            'ssl' => 1,
            'server_password' => 'hodlgang',
            'nickname' => 'IRBot',
            'altnick' => 'IRB0T',
            'username' => 'irpanel',
            'realname' => 'Internet Relay Bot',
            'nickserv_password' => 'h0dlg4ng',
            'userserv_password' => 'TMC69isth3man',
            'oper_password' => 'h0dlg4ng',
            'channels' => [
                '#c',
                '#cashmoney',
                '#c-learning',
                '#music',
                '#politics'
            ],
            'options' => [
                'transport' => 'ssl'
            ]
        ]
        /*'efnet' => [
            'server' => 'irc.efnet.org',
            'port' => 6667,
            'server_password' => '',
            'nickname' => 'IRBot',
            'altnick' => 'IRB0T',
            'username' => 'irpanel',
            'realname' => 'Internet Relay Bot',
            'nickserv_password' => '',
            'userserv_password' => '',
            'oper_password' => '',
            'channels' => [
                '#cashmoney',
                //'#havok'
            ]
        ]*/
    ]
);
