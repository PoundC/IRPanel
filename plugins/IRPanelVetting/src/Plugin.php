<?php

namespace IRPanelVetting;

use Cake\ORM\TableRegistry;
use IRPanel\Core\AbstractPlugin;
use IRPanel\Utility\Database;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

/**
 * Plugin for IRPanelVetting
 */
class Plugin extends AbstractPlugin
{
    static public $tableName = 'i_r_c_vote_proposals';

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->table = TableRegistry::get(self::$tableName);

        $this->table->primaryKey(['id']);
    }

    public function getSubscribedEvents()
    {
        if (!$this->connection) {
            return [];
        }
        return [
            'command.nominate' => 'handleNominate',
            'command.nominate.help' => 'handleNominateHelp'
        ];
    }

    public function handleNominate(CommandEvent $event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);
        $source = $event->getSource();

        if($user->isIdentified() == false) {

            return $queue->ircPrivmsg($source, 'I do not recognize you, please login to UserServ and then !ident');
        }

        $params = $event->getCustomParams();
        list($target, $message) = explode('=', implode(' ', $params));
        $target = trim($target);
        $message = trim($message);

        $targetFirst = substr($target, 0, 1);

        if(is_numeric($targetFirst)) {

            return $queue->ircPrivmsg($source, 'Nominee names can not start with an integer.');
        }

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        $proposal = $proposalsTable->find('all')->where(['name' => $target])->first();

        if($proposal) {

            $user2 = Database::getRegistrationUserById($proposal->get('i_r_c_user_registration_id'));

            return $queue->ircPrivmsg($source, 'Person already nominated with that name, created on ' . $proposal->created->format('Y-m-d') . ' by ' . $user2->get('registered_nickname') . ' please try again.');
        }

        $proposal = $proposalsTable->newEntity([
            'name' => $target,
            'description' => $message,
            'yay' => 0,
            'nay' => 0,
            'abstain' => 0,
            'completed' => 0,
            'i_r_c_user_registration_id' => $user->getRegistrationUserID(),
            'vetting' => 1,
            'created' => new \DateTime('now'),
            'modified' => new \DateTime('now')
        ]);

        $proposalsTable->save($proposal);

        $queue->ircPrivmsg($source, $target . ' Nominated[' . $proposal->id . '], Please Vote Now.');
    }

    public function handleNominateHelp(CommandEvent $event, EventQueueInterface $queue) {

        return $queue->ircPrivmsg($event->getSource(), '!nominate nickname = Why this person is awesome!');
    }

}
