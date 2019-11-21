<?php

namespace IRPanelMedia;

use Cake\ORM\TableRegistry;
use IRPanel\Core\AbstractPlugin;
use IRPanel\Utility\Database;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Event\ServerEvent;
use Phergie\Irc\Event\UserEventInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;

/**
 * Plugin for IRPanelMedia
 */
class Plugin extends AbstractPlugin
{
    static public $tableName = 'i_r_c_media';

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
            'irc.received.privmsg' => 'handleMedia'
        ];
    }

    public function handleMedia(UserEventInterface $event, EventQueueInterface $queue)
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

        if (strpos($source, '#') === 0) {

            $params = $event->getParams();
            if(isset($params['text'])) {

                $text = $params['text'];

                if (strpos($text, 'http') !== false) {
                    $link = substr($text, strpos($text, 'http'));

                    if (strpos($link, ' ') !== false) {

                        $link = explode(' ', $link)[0];
                    }
                }

                $domains = ['youtu', 'imgur'];
                $extensions = ['jpg', 'png', 'gif', 'jpeg', 'bmp', 'tiff', 'mp4'];
                $bKeep = FALSE;
                $bKeep2 = FALSE;
                $dmn = '';
                $ext = '';

                foreach ($domains as $domain) {

                    if (strpos($link, $domain) !== FALSE) {

                        $dmn = $domain;
                        $bKeep = true;
                        break;
                    }
                }

                foreach ($extensions as $extension) {

                    if (strpos($link, $extension) !== FALSE) {

                        $ext = $extension;
                        $bKeep2 = true;
                        break;
                    }
                }

                if ($bKeep == true && $bKeep2 == true) {
                    $searchable = ' ';
                    $description = ' ';
                    $title = ' ';
                    $mediaType = '';

                    if ($dmn == 'youtu') {

                        $mediaType = 'youtube';
                    } else if ($dmn == 'imgur' && strpos($link, 'gallery') !== FALSE) {
                        $mediaType = 'gallery';
                    }

                    if ($mediaType == '') {
                        if ($ext == 'mp4') {
                            $mediaType = 'video';
                        } else if ($ext != 'mp4' && $dmn != 'youtu') {
                            $mediaType = 'image';
                        }
                    }

                    if ($mediaType == 'gallery' || $mediaType == 'youtube') {
                        $searchable = file_get_contents($link);
                        preg_match("/<title>(.+)<\/title>/siU", $searchable, $matches);
                        if (isset($matches[1])) {

                            $title = $matches[1];
                        }
                        $searchable = strip_tags($searchable);

                        $tags = get_meta_tags($link);
                        if (isset($tags['description'])) {
                            $description = $tags['description'];
                        }
                    }

                    $this->loadModel('IRPanelMedia.IRCMedia');

                    $media = $this->IRCMedia->find('all')->where(['link' => $link])->first();

                    if (!$media) {
                        $mediaEntity = $this->IRCMedia->newEntity([
                            'i_r_c_users_id' => Database::getUserId(
                                Database::getNetworkId($server),
                                $nick,
                                $username,
                                $host
                            ),
                            'link' => $link,
                            'searchable' => $searchable,
                            'description' => $description,
                            'title' => $title,
                            'media_type' => $mediaType,
                            'created' => new \DateTime('now')
                        ]);

                        $this->IRCMedia->save($mediaEntity);

                        if ($mediaType == 'gallery') {
                            $html = file_get_contents($link);

                            if (strpos($html, ': {"id"') !== FALSE) {
                                $images = substr($html, strpos($html, ': {"id"'));
                                $images = substr($images, 0, strpos($images, 'adConfig":{"safe'));
                                $images = substr($images, strpos($images, '"images":[{"'));

                                $images = explode("hash", $images);

                                array_shift($images);

                                $this->loadModel('IRPanelMedia.IRCMediaGalleries');
                                foreach ($images as $image) {

                                    $hash = substr($image, 3, 7);
                                    $ext2 = substr($image, strpos($image, '"ext":"') + 7, 4);

                                    $mediaType2 = '';
                                    switch ($ext2) {
                                        case '.jpg':
                                        case '.gif':
                                        case '.bmp':
                                        case '.png':
                                            $mediaType2 = 'image';
                                            break;
                                        case '.mp4':
                                            $mediaType2 = 'video';
                                            break;
                                    }

                                    $mediaEntity2 = $this->IRCMediaGalleries->newEntity([
                                        'i_r_c_media_id' => $mediaEntity->id,
                                        'media_url' => 'https://i.imgur.com/' . $hash . $ext2,
                                        'media_type' => $mediaType2
                                    ]);
                                    $this->IRCMediaGalleries->save($mediaEntity2);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
