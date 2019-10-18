<?php

namespace IRPanel\Utility;

use Cake\ORM\TableRegistry;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

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

    public static function getRegistrationUserId($network_id, $nickname)
    {
        $usersTable = TableRegistry::get('i_r_c_user_registrations');

        $user = $usersTable->find('all')->where([
            'i_r_c_network_id' => $network_id,
            'registered_nickname' => $nickname
        ])->first();

        if(!$user) {

            $user = $usersTable->newEntity([
               'i_r_c_network_id' => $network_id,
               'registered_nickname' => $nickname
            ]);

            $usersTable->save($user);
        }

        return $user->id;
    }

    public static function getUserById($user_id) {
        $usersTable = TableRegistry::get('i_r_c_users');

        $user = $usersTable->find('all')->where([
            'id' => $user_id
        ])->first();

        return $user;
    }

    public static function getRegistrationUserById($registration_user_id) {
        $usersTable = TableRegistry::get('i_r_c_user_registrations');

        $user = $usersTable->find('all')->where([
            'id' => $registration_user_id
        ])->first();

        return $user;
    }

    public static function getUserIdByEvent(CommandEvent $event) {

        return self::getUserByEvent($event)->get('id');
    }

    public static function getUserByEvent(CommandEvent $event) {

        $nick = $event->getNick();
        $username = $event->getUsername();
        $host = $event->getHost();

        $server = strtolower($event->getConnection()->getServerHostname());

        return self::getUser(self::getNetworkId($server), $nick, $username, $host);
    }

    public static function getUser($i_r_c_network_id, $nickname, $username, $hostname) {

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

            return $userEntity;
        }

        return $user;
    }

    public static function getUserId($i_r_c_network_id, $nickname, $username, $hostname) {

        return self::getUser($i_r_c_network_id, $nickname, $username, $hostname)->get('id');
    }
}
