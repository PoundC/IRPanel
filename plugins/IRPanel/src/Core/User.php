<?php

namespace IRPanel\Core;

use Evenement\EventEmitterInterface;
use Phergie\Irc\Event\ServerEvent;
use Phergie\Irc\Client\React\Exception;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use React\EventLoop\LoopInterface;

/**
 * User class.
 *
 * @category Phergie
 * @package hashworks\Phergie\Plugin\WhoisOnJoin
 */
class User {

    protected $nick         = '';
    protected $username     = '';
    protected $realname     = '';
    protected $host         = '';
    protected $server       = '';
    protected $identifiedAs = '';

    protected $ircOperator      = false;
    protected $identified       = false;
    protected $secureConnection = false;
    protected $flagForDeletion  = false;

    protected $modes    = array();
    protected $channels = array();

    protected $i_r_c_user_id                = 0;
    protected $i_r_c_registration_user_id   = 0;

    /**
     * Queue a whois. Will call the provided callbacks once done.
     *
     * @param callable $sucessCallback
     * @param callable $errorCallback = NULL
     * @return bool

    public function queueWhois(callable $sucessCallback, callable $errorCallback = NULL) {
        $nick = $this->getNick();
        echo "\nWhoising nickname: $nick\n";
        if (!empty($nick)) {
            $this->queue->ircWhois($nick);

            $whoisUserListener = function (ServerEvent $event) use ($sucessCallback, $errorCallback) {
                $this->setServer($event->getServername());
                $this->setUsername($event->getParams()[2]);
                $this->setHost($event->getParams()[3]);
                $this->setRealname($event->getParams()[5]);
                echo $event->getMessage() . "\n";
                $listeners = array(
                    'irc.received.330' => function (ServerEvent $event) use (&$listeners) {
                        if (isset($event->getParams()[1]) && $this->getNick() != $event->getParams()[1]) {
                            $this->emitter->once('irc.received.330', $listeners['irc.received.330']);
                            return;
                        }
                        if (strpos($event->getMessage(), 'logged') !== false || strpos($event->getMessage(), 'identi') !== false || strpos($event->getMessage(), 'regist') !== false) {
                            $this->setIdentified(true);
                            $this->setIdentifiedAs($event->getParams()[2]);
                        }
                    }, // 307 [rpl_whoisregnick, not RFC standard]
                    'irc.received.rpl_whoisserver' => function (ServerEvent $event) use (&$listeners) {
                        if (isset($event->getParams()[1]) && $this->getNick() != $event->getParams()[1]) {
                            $this->emitter->once('irc.received.rpl_whoisserver', $listeners['irc.received.rpl_whoisserver']);
                            return;
                        }
                        if (isset($event->getParams()[3])) {
                            $this->setServer($event->getParams()[3]);
                        }
                    }, // 312
                    'irc.received.rpl_whoisoperator' => function (ServerEvent $event) use (&$listeners) {
                        if (isset($event->getParams()[1]) && $this->getNick() != $event->getParams()[1]) {
                            $this->emitter->once('irc.received.rpl_whoisoperator', $listeners['irc.received.rpl_whoisoperator']);
                            return;
                        }
                        $this->setIrcOperator(true);
                    }, // 313
                    'irc.received.rpl_whoischannels' => function (ServerEvent $event) use (&$listeners) {
                        if (isset($event->getParams()[1]) && $this->getNick() != $event->getParams()[1]) {
                            return; // It is called with 'on' anyway
                        }
                        if (isset($event->getParams()[2])) {
                            $this->setChannels(explode(' ', $event->getParams()[2]));
                        }
                    }, // 319
                    'irc.received.671' => function (ServerEvent $event) use (&$listeners) {
                        if (isset($event->getParams()[1]) && $this->getNick() != $event->getParams()[1]) {
                            $this->emitter->once('irc.received.671', $listeners['irc.received.671']);
                            return;
                        }
                        if (strpos($event->getMessage(), 'secure') !== false) {
                            $this->setSecureConnection(true);
                        }
                    } // 671 [rpl_whoissecure, not RFC standard]
                );

                foreach ($listeners as $event => $listener) {
                    // RPL_WHOISCHANNELS can be send multiple times if the user is in many channels
                    if ($event == 'irc.received.rpl_whoischannels') {
                        $this->emitter->on($event, $listener);
                    } else {
                        $this->emitter->once($event, $listener);
                    }
                }

                $endOfWhois = function (ServerEvent $event) use ($listeners, $sucessCallback, &$endOfWhois) {
                    if (isset($event->getParams()[1]) && $this->getNick() != $event->getParams()[1]) {
                        $this->emitter->once('irc.received.rpl_endofwhois', $endOfWhois);
                        return;
                    }
                    foreach ($listeners as $eventKey => $listener) {
                        $this->emitter->removeListener($eventKey, $listener);
                    }
                    $sucessCallback();
                };
                $this->emitter->once('irc.received.rpl_endofwhois', $endOfWhois); // 318
            };

            $noSuchNickListener = function (ServerEvent $event) use ($whoisUserListener, $errorCallback, &$noSuchNickListener) {
                if (isset($event->getParams()[1]) && $this->getNick() != $event->getParams()[1]) {
                    $this->emitter->once('irc.received.rpl_whoisuser', $noSuchNickListener);
                    return;
                }
                $this->emitter->removeListener('irc.received.rpl_whoisuser', $whoisUserListener);
                if ($errorCallback !== NULL) {
                    $errorCallback();
                }
            };

            $this->emitter->once('irc.received.rpl_whoisuser', $whoisUserListener); // 311
            $this->emitter->once('irc.received.err_nosuchnick', $noSuchNickListener); // 401

            $this->emitter->once('irc.received.rpl_whoisuser', function () use ($noSuchNickListener) {
                $this->emitter->removeListener('irc.received.err_nosuchnick', $noSuchNickListener);
            }); // 311

            return true;
        }
        return false;
    }*/

    /**
     * @return string
     */
    public function getNick () {
        return $this->nick;
    }

    /**
     * @param string $nick
     */
    public function setNick ($nick) {
        $this->nick = $nick;
    }

    /**
     * @return string
     */
    public function getUserID () {
        return $this->i_r_c_user_id;
    }

    /**
     * @param string $nick
     */
    public function setUserID ($id) {
        $this->i_r_c_user_id = $id;
    }

    /**
     * @return string
     */
    public function getRegistrationUserID () {
        return $this->i_r_c_registration_user_id;
    }

    /**
     * @param string $nick
     */
    public function setRegistrationUserID ($id) {
        $this->i_r_c_registration_user_id = $id;
    }

    /**
     * @return string
     */
    public function getUsername () {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername ($username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getRealname () {
        return $this->realname;
    }

    /**
     * @param string $realname
     */
    public function setRealname ($realname) {
        $this->realname = $realname;
    }

    /**
     * @return string
     */
    public function getHost () {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost ($host) {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getServer () {
        return $this->server;
    }

    /**
     * @param string $server
     */
    public function setServer ($server) {
        $this->server = $server;
    }

    /**
     * @return boolean
     */
    public function isIrcOperator () {
        return $this->ircOperator;
    }

    /**
     * @param boolean $isIrcOperator
     */
    public function setIrcOperator ($isIrcOperator) {
        $this->ircOperator = boolval($isIrcOperator);
    }

    /**
     * @return boolean
     */
    public function isIdentified () {
        return $this->identified;
    }

    /**
     * @param boolean $isIdentified
     */
    public function setIdentified ($isIdentified) {
        $this->identified = boolval($isIdentified);
    }

    /**
     * @param boolean $isIdentified
     */
    public function setIdentifiedAs ($identifiedAs) {
        $this->identifiedAs = $identifiedAs;
    }

    /**
     * @return boolean
     */
    public function isIdentifiedAs () {
        return $this->identifiedAs;
    }

    /**
     * @return boolean
     */
    public function hasSecureConnection () {
        return $this->secureConnection;
    }

    /**
     * @param boolean $hasSecureConnection
     */
    public function setSecureConnection ($hasSecureConnection) {
        $this->secureConnection = boolval($hasSecureConnection);
    }

    /**
     * @return string[]
     */
    public function getModes () {
        return $this->modes;
    }

    /**
     * @param string[] $modes
     */
    public function setModes ($modes) {
        $this->modes = $modes;
    }

    /**
     * @return string[]
     */
    public function getChannels () {
        return $this->channels;
    }

    /**
     * @param string[] $channels
     */
    public function setChannels ($channels) {
        $this->channels = $channels;
    }

    public function setFlagForDeletion($trueOrFalse) {

        $this->flagForDeletion = boolval($trueOrFalse);
    }

    public function getFlagForDeletion()
    {
        return $this->flagForDeletion;
    }

}
