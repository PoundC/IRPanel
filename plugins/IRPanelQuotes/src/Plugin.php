<?php

namespace IRPanelQuotes;

use IRPanel\Core\AbstractPlugin;
use Cake\ORM\TableRegistry;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;
use IRPanel\Utility\Database;

/**
 * Plugin for IRPanelQuotes
 */
class Plugin extends AbstractPlugin
{
    static public $tableName = 'i_r_c_quotes';

    protected $connection = 'default';
    protected $table;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        if (isset($config['connection'])) {
            $this->connection = $config['connection'];
        }

        $this->table = TableRegistry::get(self::$tableName);

        $this->table->primaryKey(['id']);
    }

    public function getSubscribedEvents()
    {
        if (!$this->connection) {
            return [];
        }
        return [
            'command.calc' => 'handleSaveCalc',
            'command.c' => 'handleRandomCalc',
            'command.search' => 'handleSearchCalc',
            'command.calc.help' => 'handleSaveCalcHelp',
            'command.c.help' => 'handleRandomCalcHelp',
            'command.search.help' => 'handleSearchCalcHelp'
        ];
    }

    public function handleSaveCalc(CommandEvent $event, EventQueueInterface $queue)
    {
        $source = $event->getSource();
        $nick = $event->getNick();
        $username = $event->getUsername();
        $host = $event->getHost();

        $server = strtolower($event->getConnection()->getServerHostname());

        $channel = $event->getParams();
        if(isset($channel['receivers'])) {

            $channel = $channel['receivers'];
        }
        else {

            $channel = null;
        }

        $params = $event->getCustomParams();
        list($target, $message) = explode('=', implode(' ', $params));
        $target = trim($target);
        $message = trim($message);

        $calc = $this->table->find('all')->where(['topic' => $target])->first();
        if(!$calc) {

            $calcEntity = $this->table->newEntity([
                'i_r_c_user_id' => Database::getChannelId(Database::getNetworkId($server), $nick, $username, $host),
                'topic' => $target,
                'quote' => $message,
                'created' => new \DateTime('now')
            ]);

            $this->table->save($calcEntity);

            $this->showCalc($queue, $source, $calcEntity);
        }
        else {

            $calc->set('message', $message);
            $this->table->save($calc);

            $this->showCalc($queue, $source, $calc);
        }
    }

    public function showCalc(EventQueueInterface $queue, $source, $calcEntity)
    {
        $queue->ircPrivmsg($source, $calcEntity->topic . ' = ' . $calcEntity->quote);
    }

    public function handleRandomCalc(CommandEvent $event, EventQueueInterface $queue) {

        $source = $event->getSource();
        $nick = $event->getNick();
        $username = $event->getUsername();
        $host = $event->getHost();

        $server = strtolower($event->getConnection()->getServerHostname());

        $channel = $event->getParams();
        if(isset($channel['receivers'])) {

            $channel = $channel['receivers'];
        }
        else {

            $channel = null;
        }

        $params = $event->getCustomParams();

        if(count($params) == 1) {

            $calc = $this->table->find('all')->where(['topic' => $params[0]])->first();

            if(!$calc) {

                $queue->ircPrivmsg($source, 'No calc found.');
            }
            else {

                $this->showCalc($queue, $source, $calc);
            }
        }
        else if(count($params) === 0)
        {
            $calc = $this->table->find('all')->order('rand()')->first();

            $this->showCalc($queue, $source, $calc);
        }
        else
        {
            return $this->handleRandomCalcHelp($event, $queue);
        }
    }

    public function handleSearchCalc(CommandEvent $event, EventQueueInterface $queue) {

        $source = $event->getSource();
        $nick = $event->getNick();
        $username = $event->getUsername();
        $host = $event->getHost();

        $server = strtolower($event->getConnection()->getServerHostname());

        $channel = $event->getParams();
        if(isset($channel['receivers'])) {

            $channel = $channel['receivers'];
        }
        else {

            $channel = null;
        }

        $params = $event->getCustomParams();

        if(count($params) == 1) {

            $calcsQuery = $this->table->find('all')
                ->where(['topic LIKE' => '%' . $params[0] . '%'])
                ->orWhere(['quote LIKE' => '%' . $params[0] . '%']);

            $calcCount = $calcsQuery->count();
            $calcs = $calcsQuery->limit(7)->all();

            if(!$calcs) {

                $queue->ircPrivmsg($source, 'No calc found.');
            }
            else {

                $results = '';

                foreach($calcs as $calc) {

                    $results = $results . $calc->topic . ', ';
                }

                $results = rtrim($results, ', ');

                $queue->ircPrivmsg($source, 'Results[' . $calcCount . ']: ' . $results);
            }
        }
        else if(count($params) == 2) {

            $calcsQuery = $this->table->find('all')
                ->where(['topic LIKE' => '%' . $params[0] . '%'])
                ->orWhere(['quote LIKE' => '%' . $params[0] . '%']);

            $calcCount = $calcsQuery->count();
            $calcs = $calcsQuery->limit(7)->page($params[1])->all();

            if(!$calcs) {

                $queue->ircPrivmsg($source, 'No calc found.');
            }
            else {

                $results = '';

                foreach($calcs as $calc) {

                    $results = $results . $calc->topic . ', ';
                }

                $results = rtrim($results, ', ');

                $queue->ircPrivmsg($source, 'Results[' . $calcCount . '][' . $params[1] . ']: ' . $results);
            }
        }
        else if(count($params) === 0 || count($params) > 2)
        {
            return $this->handleRandomCalcHelp($event, $queue);
        }
    }

    public function handleSaveCalcHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircPrivmsg($event->getSource(), "\x02Usage:\x02 calc <topic> = <quote>");
    }

    public function handleRandomCalcHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircPrivmsg($event->getSource(), "\x02Usage:\x02 c");
        $queue->ircPrivmsg($event->getSource(), "\x02Usage:\x02 c <topic>");
    }

    public function handleSearchCalcHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircPrivmsg($event->getSource(), "\x02Usage:\x02 search <topic>");
    }
}
