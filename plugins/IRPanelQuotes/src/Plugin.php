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
            'command.calc' => 'handleSaveCalc',
            'command.c' => 'handleRandomCalc',
            'command.search' => 'handleSearchCalc',
            'command.rmcalc' => 'handleRmCalc',
            'command.calc.help' => 'handleSaveCalcHelp',
            'command.c.help' => 'handleRandomCalcHelp',
            'command.search.help' => 'handleSearchCalcHelp',
            'command.rmcalc.help' => 'handleRmCalcHelp',
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
        if(strpos(implode(' ', $params), '=') === false) {

            return $queue->ircNotice($source, $nick . ': Did not find `=`, please see !calc.help for example.');
        }

        list($target, $message) = explode('=', implode(' ', $params));
        $target = trim($target);
        $message = implode(' ', $params);
        $message = str_replace($target . ' = ', '', $message);
        $message = trim($message);

        $calc = $this->table->find('all')->where(['topic' => $target])->first();
        if(!$calc) {

            $calcEntity = $this->table->newEntity([
                'i_r_c_user_id' => Database::getUserId(Database::getNetworkId($server), $nick, $username, $host),
                'topic' => $target,
                'quote' => $message,
                'created' => new \DateTime('now')
            ]);

            $this->table->save($calcEntity);

            $queue->ircNotice($source, "\x02" . $calcEntity->topic . "\x02 = " . $calcEntity->quote);
        }
        else {

            $calc->set('quote', $message);
            $this->table->save($calc);

            $this->showCalc($queue, $source, $calc);
        }
    }

    public function showCalc(EventQueueInterface $queue, $source, $calcEntity)
    {
        $queue->ircPrivmsg($source, "\x02" . $calcEntity->topic . "\x02 = " . $calcEntity->quote);
    }

    public function handleRmCalc(CommandEvent $event, EventQueueInterface $queue)
    {
        $source = $event->getSource();
        $nick = $event->getNick();
        $username = $event->getUsername();
        $host = $event->getHost();

        $server = strtolower($event->getConnection()->getServerHostname());

        $channel = $event->getParams();
        if (isset($channel['receivers'])) {

            $channel = $channel['receivers'];
        } else {

            $channel = null;
        }

        $params = $event->getCustomParams();

        if (count($params) == 1) {

            $calc = $this->table->find('all')->where(['topic' => $params[0]])->first();

            if($calc) {

                $this->table->delete($calc);

                return $queue->ircNotice($source, $nick . ': Calc Deleted.');
            }
            else {

                return $queue->ircNotice($source, 'No calc with that topic found.');
            }
        }
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

                $queue->ircNotice($source, 'No calc found.');
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

            if($calcCount == 0) {

                $queue->ircNotice($source, 'No calc found.');
            }
            else {

                $results = '';

                foreach($calcs as $calc) {

                    $results = $results . $calc->topic . ', ';
                }

                $results = rtrim($results, ', ');

                $queue->ircNotice($source, 'Results[' . $calcCount . ']: ' . $results);
            }
        }
        else if(count($params) == 2 && is_numeric($params[1])) {

            $calcsQuery = $this->table->find('all')
                ->where(['topic LIKE' => '%' . $params[0] . '%'])
                ->orWhere(['quote LIKE' => '%' . $params[0] . '%']);

            $calcCount = $calcsQuery->count();
            $calcs = $calcsQuery->limit(7)->page($params[1])->all();

            if(!$calcs) {

                $queue->ircNotice($source, 'No calc found.');
            }
            else {

                $results = '';

                foreach($calcs as $calc) {

                    $results = $results . $calc->topic . ', ';
                }

                $results = rtrim($results, ', ');

                $queue->ircNotice($source, 'Results[' . $calcCount . '][' . $params[1] . ']: ' . $results);
            }
        }
        else if(count($params) == 2 && !is_numeric($params[1])) {
            return $queue->ircNotice($source, $nick . ': Do not recognize that command, !search.help for example.');
        }
        else if(count($params) === 0 || count($params) > 2)
        {
            return $this->handleRandomCalcHelp($event, $queue);
        }
    }

    public function handleSaveCalcHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), "\x02Usage:\x02 calc <topic> = <quote>");
    }

    public function handleRandomCalcHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), "\x02Usage:\x02 c");
        $queue->ircNotice($event->getSource(), "\x02Usage:\x02 c <topic>");
    }

    public function handleSearchCalcHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), "\x02Usage:\x02 search <one_word> [page_number]");
    }

    public function handleRmCalcHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), "\x02Usage:\x02 rmcalc <topic>");
    }
}
