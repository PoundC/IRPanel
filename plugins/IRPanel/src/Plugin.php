<?php

namespace IRPanel;

use IRPanel\Core\User;
use IRPanel\Core\AbstractPlugin;
use Cake\ORM\TableRegistry;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;
use IRPanel\Utility\Database;
use Phergie\Irc\Event\ServerEvent;
use Phergie\Irc\Event\UserEvent;

/**
 * Plugin for IRPanelQuotes
 */
class Plugin extends AbstractPlugin
{
    static public $tableName = 'i_r_c_user_idents';

    public function getSubscribedEvents()
    {
        if (!$this->connection) {
            return [];
        }
        return [
            'command.ident' => 'handleIdent',
            'irc.received.rpl_namreply' => 'handleNames',
            'irc.received.rpl_whoisuser' => 'handle311',
            'irc.received.330' => 'handle330',
            'irc.received.rpl_whoisserver' => 'handleServer',
            'irc.received.rpl_whoisoperator' => 'handleOperator',
            'irc.received.rpl_whoischannels' => 'handleChannels',
            'irc.received.671' => 'handleSecure',
            'irc.received.rpl_endofwhois' => 'handleEndWhois',
            'irc.received.join' => 'handleJoin',
            'irc.received.nick' => 'handleNick',
            'irc.received.part' => 'handlePart',
            'irc.received.quit' => 'handleQuit',
        ];
    }

    public function handleIdent(CommandEvent $event, EventQueueInterface $queue)
    {
        $nick = $event->getNick();

        $queue->ircWhois($nick);
    }

    public function handleNames($event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $users = $params[3];
        $users = explode(' ', $users);

        foreach($users as $user) {

            if(strpos($user, '@') !== false) {
                $nick = substr($user, 1);
            }
            else if(strpos($user, '+') !== false) {
                $nick = substr($user, 1);
            }
            else {
                $nick = $user;
            }

            $user = new User();
            $user->setNick($nick);

            $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);

            $queue->ircWhois($nick);

            usleep(10000);
        }
    }

    public function handle311(ServerEvent $event, EventQueueInterface $queue) {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $nick = $params[1];

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        $user->setUsername($event->getParams()[2]);
        $user->setHost($event->getParams()[3]);
        $user->setRealname($event->getParams()[5]);

        $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);
    }

    public function handle330(ServerEvent $event, EventQueueInterface $queue) {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $nick = $params[1];

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if (strpos($event->getMessage(), 'logged') !== false || strpos($event->getMessage(), 'identi') !== false || strpos($event->getMessage(), 'regist') !== false) {
            $user->setIdentified(true);
            $user->setIdentifiedAs($event->getParams()[2]);
            $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);
        }
    }

    public function handleServer(ServerEvent $event, EventQueueInterface $queue) {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $nick = $params[1];

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if (isset($event->getParams()[3])) {

            $user->setServer($event->getParams()[3]);

            $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);
        }
    }

    public function handleOperator(ServerEvent $event, EventQueueInterface $queue)
    {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $nick = $params[1];

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        $user->setIrcOperator(true);

        $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);
    }

    public function handleChannels(ServerEvent $event, EventQueueInterface $queue) {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $nick = $params[1];

        $bot = $this->client->readDataStorage($networkId . '.Users.' . $event->getConnection()->getNickname());

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if (isset($event->getParams()[2])) {

            $channels = explode(' ', $event->getParams()[2]);
            array_pop($channels);

            $chans = [];

            foreach($channels as $channel) {

                if(substr($channel, 0, 1) != '#') {
                    $chans[] = substr($channel, 1);
                }
                else {
                    $chans[] = $channel;
                }
            }

            $user->setChannels($chans);

            $bStillHaveChannels = false;
            foreach($bot->getChannels() as $channel) {

                if(in_array($channel, $chans) === true) {

                    $bStillHaveChannels = true;
                    break;
                }
            }

            if($bStillHaveChannels == false) {

                $user->setFlagForDeletion(true);
            }
        }
        else {

            $user->setFlagForDeletion(true);
        }

        $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);
    }

    public function handleSecure(ServerEvent $event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $nick = $params[1];

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        $user->setSecureConnection(true);

        $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);
    }

    public function handleEndWhois(ServerEvent $event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $params = $event->getParams();

        $nick = $params[1];

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if($user != NULL && $user->isIdentified() == 1) {

            $nickname = $user->isIdentifiedAs();

            $user->setRegistrationUserId(Database::getRegistrationUserId($networkId, $nickname));
            $user->setUserId(Database::getUserId($networkId, $user->getNick(), $user->getUsername(), $user->getHost()));

            if ($user->getFlagForDeletion() == true) {

                $this->client->deleteDataStorage($networkId . '.Users.' . $nick);
            }
        }
    }

    public function handleJoin(UserEvent $event, EventQueueInterface $queue)
    {
        $nick = $event->getNick();

        $queue->ircWhois($nick);
    }

    public function handlePart(UserEvent $event, EventQueueInterface $queue)
    {
        $nick = $event->getNick();

        $queue->ircWhois($nick);
    }

    public function handleNick(UserEvent $event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());

        $nick = $event->getNick();

        $params = $event->getParams();

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);
        $this->client->deleteDataStorage($networkId . '.Users.' . $nick);

        $user->setNick($params['nickname']);

        $nick = $params['nickname'];

        $this->client->writeDataStorage($networkId . '.Users.' . $nick, $user);
    }

    public function handleQuit(UserEvent $event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();

        $this->client->deleteDataStorage($networkId . '.Users.' . $nick);

        $queue->ircWhois($nick);
    }
}
