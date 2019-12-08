<?php

namespace IRPanelJams;

use Cake\ORM\TableRegistry;
use IRPanel\Core\AbstractPlugin;
use IRPanel\Utility\Database;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Event\ServerEvent;
use Phergie\Irc\Event\UserEventInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

/**
 * Plugin for IRPanelJams
 */
class Plugin extends AbstractPlugin
{
    static public $tableName = 'i_r_c_jams';

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
            'command.jam' => 'handleJam'
        ];
    }

    public function handleJam(CommandEvent $event, EventQueueInterface $queue)
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

        if(strpos($params[0], 'youtu') !== false) {

            $youTubeLink = $params[0];
            $this->loadModel('IRPanelJams.IRCJams');
            $this->loadModel('IRPanelJams.IRCJamsQueue');

            $jam = $this->IRCJams->find('all')->where(['link' => $youTubeLink])->first();

            if (!$jam) {
                $searchable = ' ';
                $description = ' ';
                $title = ' ';
                $mediaType = '';

                $searchable = file_get_contents($youTubeLink);
                preg_match("/<title>(.+)<\/title>/siU", $searchable, $matches);
                if (isset($matches[1])) {

                    $title = $matches[1];
                }
                $searchable = strip_tags($searchable);

                $tags = get_meta_tags($youTubeLink);
                if (isset($tags['description'])) {
                    $description = $tags['description'];
                }

                $jamEntity = $this->IRCJams->newEntity([
                    'i_r_c_users_id' => Database::getUserId(
                        Database::getNetworkId($server),
                        $nick,
                        $username,
                        $host,
                        Database::getServerId($server)
                    ),
                    'link' => $youTubeLink,
                    'searchable' => $searchable,
                    'description' => $description,
                    'title' => $title,
                    'created' => new \DateTime('now')
                ]);

                $this->IRCJams->save($jamEntity);

                $this->queueJam($jamEntity->id, Database::getUserId(
                    Database::getNetworkId($server),
                    $nick,
                    $username,
                    $host,
                    Database::getServerId($server)
                ));

                return $queue->ircNotice($source, 'Jam saved and queued, Visit Player to view!');
            }
            else {

                $jamResponse = $this->queueJam($jam->id, Database::getUserId(
                    Database::getNetworkId($server),
                    $nick,
                    $username,
                    $host,
                    Database::getServerId($server)
                ));

                return $queue->ircNotice($source, $jamResponse . ', Visit Player to view!');
            }
        }
        else {

            return $queue->ircNotice($source, 'We only accept youtube jams here pal.');
        }
    }

    private function queueJam($jam_id, $user_id)
    {
        $this->loadModel('IRPanelJams.IRCJamsQueue');

        $jamQueue = $this->IRCJamsQueue->find('all')->where(['i_r_c_jam_id' => $jam_id, 'played' => 'no'])->first();

        if(!$jamQueue) {
            $jamQueueEntity = $this->IRCJamsQueue->newEntity([
                'i_r_c_jam_id' => $jam_id,
                'i_r_c_users_id' => $user_id,
                'played' => 'no',
                'playedts' => new \DateTime(),
                'created' => new \DateTime()
            ]);

            $this->IRCJamsQueue->save($jamQueueEntity);

            return 'Jam queued';
        }
        else {

            return 'Jam already queued';
        }
    }
}
