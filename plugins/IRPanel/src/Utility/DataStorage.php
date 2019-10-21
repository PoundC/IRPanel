<?php

namespace IRPanel\Utility;

use IRPanel\Utility\Database;
use Phergie\Irc\Plugin\React\Command\CommandEvent;
use Phergie\Irc\Client\React\ClientInterface;

class DataStorage {

    public static function getUserStorageId(CommandEvent $event)
    {
        return Database::getNetworkId($event->getConnection()->getServerHostname()) . '.Users.' . $event->getNick();
    }

    public static function getUser(ClientInterface $client, CommandEvent $event)
    {
        return $client->readDataStorage(DataStorage::getUserStorageId($event));
    }
}
