<?php

namespace IRPanel\Utility;

use Cake\ORM\TableRegistry;

class Database
{
    public static function getNetworkId($serverHostname) {

        $serversTable = TableRegistry::get('i_r_c_servers');

        $server = $serversTable->find('all')->where(['hostname' => $serverHostname])->first();

        return $server->i_r_c_network_id;
    }

    public static function getChannelId($i_r_c_network_id, $pound_name) {

        $channelsTable = TableRegistry::get('i_r_c_channels');

        $channel = $channelsTable->find('all')->where([
            'i_r_c_network_id' => $i_r_c_network_id,
            'pound_name' => $pound_name
        ])->first();

        if(!$channel) {

            $channelsTable->connection()->driver()->autoQuoting(true);

            // TODO: Populate this via Web Interface, and Join Channels Via DB Lookup
            $channelEntity = $channelsTable->newEntity([
                'i_r_c_network_id' => $i_r_c_network_id,
                'pound_name' => $pound_name,
                'keys' => '',
                'knock_nick' => '',
                'topic' => ''
            ]);

            $channelsTable->save($channelEntity);

            $channelsTable->connection()->driver()->autoQuoting(false);

            return $channelEntity->id;
        }

        return $channel->id;
    }

    public static function getUserId($i_r_c_network_id, $nickname, $username, $hostname) {

        $usersTable = TableRegistry::get('i_r_c_users');

        $user = $usersTable->find('all')->where([
            'i_r_c_network_id' => $i_r_c_network_id,
            'username' => $username,
            'hostname' => $hostname,
            'nickname' => $nickname
        ])->first();

        if(!$user) {

            $userEntity = $usersTable->newEntity([
                'i_r_c_network_id' => $i_r_c_network_id,
                'username' => $username,
                'hostname' => $hostname,
                'nickname' => $nickname,
                'realname' => '' // TODO: Do Whois, Get RealName
            ]);

            $usersTable->save($userEntity);

            return $userEntity->id;
        }

        return $user->id;
    }
}
