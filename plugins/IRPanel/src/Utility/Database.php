<?php

namespace IRPanel\Utility;

use Cake\ORM\TableRegistry;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

class Database
{
    public static function getServerId($serverHostname) {

        $serversTable = TableRegistry::get('i_r_c_servers');

        $server = $serversTable->find('all')->where(['hostname' => $serverHostname])->first();

        if($server == null)
        {
            return 0;
        }

        return $server->id;
    }

    public static function getNetwork($networkName) {

        $serversTable = TableRegistry::get('i_r_c_networks');

        $server = $serversTable->find('all')->where(['network_name' => $networkName])->first();

        return $server->id;
    }

    public static function getNetworkId($serverHostname) {

        $serversTable = TableRegistry::get('i_r_c_servers');

        $server = $serversTable->find('all')->where(['hostname' => $serverHostname])->first();

        if($server) {
            return $server->i_r_c_network_id;
        }

        return 0;
    }

    /*
        +-------------------+-------------+------+-----+---------+----------------+
        | Field             | Type        | Null | Key | Default | Extra          |
        +-------------------+-------------+------+-----+---------+----------------+
        | id                | int(11)     | NO   | PRI | NULL    | auto_increment |
        | network_name      | varchar(64) | NO   |     | NULL    |                |
        | username          | varchar(64) | NO   |     | NULL    |                |
        | realname          | varchar(64) | NO   |     | NULL    |                |
        | nickname          | varchar(64) | NO   |     | NULL    |                |
        | altnick           | varchar(64) | NO   |     | NULL    |                |
        | nickserv_password | varchar(64) | NO   |     | NULL    |                |
        +-------------------+-------------+------+-----+---------+----------------+
     */
    public static function insertNetwork($network_name)
    {
        $networksTable = TableRegistry::get('i_r_c_networks');

        $newNetwork = $networksTable->newEntity();
        $newNetwork->set('network_name', $network_name);
        $networksTable->save($newNetwork);

        return $newNetwork->get('id');
    }

    /*
        +------------------+-------------+------+-----+---------+----------------+
        | Field            | Type        | Null | Key | Default | Extra          |
        +------------------+-------------+------+-----+---------+----------------+
        | id               | int(11)     | NO   | PRI | NULL    | auto_increment |
        | i_r_c_network_id | int(11)     | NO   |     | NULL    |                |
        | hostname         | varchar(64) | NO   |     | NULL    |                |
        | port             | int(11)     | NO   |     | NULL    |                |
        | server_password  | varchar(64) | NO   |     | NULL    |                |
        | oper_password    | varchar(64) | NO   |     | NULL    |                |
        | ssl              | int(11)     | NO   |     | NULL    |                |
        +------------------+-------------+------+-----+---------+----------------+
     */

    public static function insertServer($networkId, $hostname, $port, $server_password, $oper_password, $ssl)
    {
        $serverTable = TableRegistry::get('i_r_c_servers');

        $serverEntity = $serverTable->newEntity();
        $serverEntity->set('i_r_c_network_id', $networkId);
        $serverEntity->set('hostname', $hostname);
        $serverEntity->set('port', $port);
        $serverEntity->set('server_password', $server_password);
        $serverEntity->set('oper_password', $oper_password);
        $serverEntity->set('ssl', $ssl);
        $serverTable->save($serverEntity);

        return $serverEntity->get('id');
    }

    /*
         MariaDB [irpanel]> show columns from i_r_c_channels;
        +------------------+---------------+------+-----+---------+----------------+
        | Field            | Type          | Null | Key | Default | Extra          |
        +------------------+---------------+------+-----+---------+----------------+
        | id               | int(11)       | NO   | PRI | NULL    | auto_increment |
        | i_r_c_network_id | int(11)       | NO   |     | NULL    |                |
        | pound_name       | varchar(64)   | NO   |     | NULL    |                |
        | keys             | varchar(64)   | NO   |     | NULL    |                |
        | knock_nick       | varchar(32)   | NO   |     | NULL    |                |
        | topic            | varchar(1024) | NO   |     | NULL    |                |
        +------------------+---------------+------+-----+---------+----------------+
     */

    public static function insertChannel($networkId, $poundName)
    {
        $channelTable = TableRegistry::get('i_r_c_channels');

        $channelEntity = $channelTable->newEntity();
        $channelEntity->set('i_r_c_network_id', $networkId);
        $channelEntity->set('pound_name', $poundName);
        $channelTable->save($channelEntity);

        return $channelEntity->get('id');
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

    public static function getUser($i_r_c_network_id, $nickname, $username, $hostname, $i_r_c_server_id = 1) {

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
                'i_r_c_server_id' => $i_r_c_server_id,
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

    public static function getUserId($i_r_c_network_id, $nickname, $username, $hostname, $i_r_c_server_id = 1) {

        return self::getUser($i_r_c_network_id, $nickname, $username, $hostname, $i_r_c_server_id)->get('id');
    }
}
