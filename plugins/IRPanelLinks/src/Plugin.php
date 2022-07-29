<?php

namespace IRPanelLinks;

use Cake\ORM\TableRegistry;
use IRPanel\Core\AbstractPlugin;
use IRPanel\Utility\Database;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Event\ServerEvent;
use Phergie\Irc\Event\UserEventInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

/**
 * Plugin for IRPanelLinks
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
            'irc.received.privmsg' => 'handleLinks'
        ];
    }

    public function handleLinks(UserEventInterface $event, EventQueueInterface $queue)
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

        if(strpos($source, '#') === 0) {

            $params = $event->getParams();
            if(isset($params['text'])) {

                $text = $params['text'];

                if(strpos($text, 'http') !== false) {

                    $link = substr($text, strpos($text, 'http'));

                    if(strpos($link, ' ') !== false) {

                        $link = explode(' ', $link)[0];
                    }

                    $this->loadModel('IRPanelLinks.IRCLinks');
                    $link2 = $this->IRCLinks->find('all')->where(['link' => $link])->first();

                    if(!$link2) {

                        $html = file_get_contents($link);
                        if($html) {

                            $bIsTextHTML = false;
                            foreach($http_response_header as $key => $value)
                            {
                                if(strpos(strtolower($value), 'text/html'))
                                {
                                    $bIsTextHTML = true;
                                }
                            }

                            if($bIsTextHTML) {
                                preg_match("/<title>(.+)<\/title>/siU", $html, $matches);
                                if (isset($matches[1])) {

                                    $title = $matches[1];
                                } else {

                                    $title = '';
                                }

                                $searchable = strip_tags($html);

                                $tags = get_meta_tags($link);
                                if (isset($tags['description'])) {
                                    $descr = $tags['description'];
                                } else {
                                    $descr = '';
                                }

                                $linkEntity = $this->IRCLinks->newEntity([
                                    'i_r_c_users_id' => Database::getUserId(
                                        Database::getNetworkId($server),
                                        $nick,
                                        $username,
                                        $host
                                    ),
                                    'i_r_c_channel_id' => Database::getChannelId(Database::getNetworkId($server), $channel),
                                    'link' => $link,
                                    'searchable' => $searchable,
                                    'description' => $descr,
                                    'title' => $title,
                                    'created' => new \DateTime('now')
                                ]);
                                $this->IRCLinks->save($linkEntity);
                                $fname = md5($link);
                                $fletter = substr($fname, 0, 1);

                                if(file_exists("/var/www/irpanel/webroot/ss/" . $fletter . "/" . $fname) == false) {
                                    echo "Taking screenshot: /usr/bin/python3 /var/www/irpanel/chrome/ss.py " . $fletter . " " . $fname . " " . $link . "\n" ;
                                    passthru("/var/www/irpanel/chrome/.venv/bin/python3 /var/www/irpanel/chrome/ss.py " . $fletter . " " . $fname . " " . $link);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
