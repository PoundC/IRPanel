<?php

return [
    'networks' => [
        'poundc' => [
            'server' => 'irc.poundc.com',
            'port' => 6697,
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
    ]
];
