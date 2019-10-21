<?php

namespace IRPanelGame;

use IRPanel\Core\AbstractPlugin;
use Cake\ORM\TableRegistry;
use IRPanel\Utility\DataStorage;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;
use IRPanel\Utility\Database;

/**
 * Plugin for IRPanelQuotes
 */
class Plugin extends AbstractPlugin
{
    // Get Cash by Working
    // Spend Cash (Buy Items, Animals, People, Properties)
    // Use Items to Power Up Commands (Work, Buy, Use, Sex, Fight, Hack, Steal, Smack, Visit)
    // Sex Animals/People to Create Mutants/Offspring and Earn Points
    // Fight Animals/People to Earn Cash and Points
    // Hack Shit to Earn Cash and Points and Advantages Over Items, Animals, People, Properties
    // Steal Cash, Items, Animals, People, Properties
    // Smack Another User To Start Shit
    // Visit Properties, People, Animals to Earn Cash, Points, and Advantages
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function getSubscribedEvents()
    {
        if (!$this->connection) {
            return [];
        }
        return [
            'irpanel.command.register' => 'handleRegister',
            'command.work' => 'handleWork',
            'command.add' => 'handleAddFeature'
            // 'irpanel.command.voting.vote.yay' => 'handleVoteYay',
            // 'irpanel.command.quotes.calc' => 'handleCalc'
        ];
    }

    public function handleAddFeature(CommandEvent $event, EventQueueInterface $queue)
    {
        $user = DataStorage::getUser($this->getClient(), $event);

        if(!$user->isIdentified()) {

            return $queue->ircNotice(
                $event->getSource(),
                $event->getNick() . ': (IRPanelGame) I do not recognize you, please login and ident.'
            );
        }

        $this->loadModel('IRPanelGame.IRCGamePlayers');

        $player = $this->IRCGamePlayers->find('all')->where([
            'i_r_c_user_registration_id' => $user->getRegistrationUserId()
        ])->first();


    }

    public function handleRegister(CommandEvent $event, EventQueueInterface $queue)
    {
        $user = $this->client->readDataStorage(DataStorage::getUserStorageId($event));
        $this->loadModel('IRCGamePlayers');

        $player = $this->IRCGamePlayers->find('all')->where([
            'i_r_c_user_registration_id' => $user->getRegistrationUserId()
        ])->first();

        if($player) {

            return $queue->ircNotice(
                $event->getSource(),
                $event->getNick() . ': (IRPanelGame) Already Registered.'
            );
        }

        $playerEntity = $this->IRCGamePlayers->newEntity([
            'i_r_c_user_registration_id' => $user->getRegistrationUserId(),
            'cash' => 0,
            'points' => 0,
            'score' => 0,
            'power' => 1,
            'war_cry' => '',
            'o_noise' => '',
            'hack_words' => '',
            'steal_slogan' => '',
            'smack_words' => '',
            'greeting' => '',
            'lotto_one' => 0,
            'lotto_two' => 0,
            'lotto_three' => 0,
            'lotto_four' => 0,
            'lotto_five' => 0,
            'lotto_six' => 0,
            'created' => new \DateTime('now'),
            'modified' => new \DateTime('now')
        ]);

        $this->IRCGamePlayers->save($playerEntity);

        $this->loadModel('IRPanelGame.IRCGameFeatures');
        $this->loadModel('IRPanelGame.IRCGamePlayerFeatures');

        $job = $this->IRCGameFeatures->find('all')->where([
            'feature_type' => 'job',
            'feature_name' => 'corner'
        ])->first();

        $playerFeatureEntity = $this->IRCGamePlayerFeatures->newEntity([
            'i_r_c_game_player_id' => $playerEntity->id,
            'i_r_c_game_feature_id' => $job->id,
            'power_power' => 1,
            'created' => new \DateTime('now'),
            'modified' => new \DateTime('now')
        ]);

        $this->IRCGamePlayerFeatures->save($playerFeatureEntity);

        $queue->ircNotice(
            $event->getSource(),
            $event->getNick() . ': You are now registered in the game. Happy Playing.'
        );
    }

    public function handleWork(CommandEvent $event, EventQueueInterface $queue)
    {
        $source = $event->getSource();
        $nick = $event->getNick();
        $username = $event->getUsername();
        $host = $event->getHost();

        $server = strtolower($event->getConnection()->getServerHostname());
        $networkId = Database::getNetworkId($server);

        $params = $event->getCustomParams();

        $this->loadModel('IRPanelGame.IRCGamePlayerFeatures');
        $this->loadModel('IRPanelGame.IRCGameLogs');

        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if($user == null) {

            return $queue->ircNotice($source, $nick . ': I do not recognize you, please login and ident.');
        }

        $this->loadModel('IRPanelGame.IRCGamePlayers');

        $player = $this->IRCGamePlayers->find('all')->where([
            'i_r_c_user_registration_id' => $user->getRegistrationUserId()
        ])->first();

        if(!$player)
        {
            return $queue->ircNotice(
                $source,
                $nick . ': I do not recognize you, Have you registered? Please login and ident.'
            );
        }

        if(count($params) == 0)
        {
            // Work Random Job
            $job = $this->IRCGamePlayerFeatures->find('all', ['contain' => ['IRCGameFeatures']])->where([
                'i_r_c_game_player_id' => $player->id
            ])->order('rand()')->first();

            if(!$job) {

                return $queue->ircNotice($source, $nick . ': No jobs found, please !register');
            }

            print_r($job);
        }
        else if(count($params) == 1)
        {
            // Work Specific Job
        }
        else if(count($params) == 2 && is_numeric($params[1]))
        {
            // Work Specific Job For X Hours
        }
        else {

            $queue->ircNotice($source, $nick . ': Incorrect Parameters, Please try again.');
        }
    }

    public function wow(CommandEvent $event, EventQueueInterface $queue)
    {
        $source = $event->getSource();
        $nick = $event->getNick();
        $username = $event->getUsername();
        $host = $event->getHost();

        $server = strtolower($event->getConnection()->getServerHostname());
        $networkId = Database::getNetworkId($server);

        $channel = $event->getParams();
        if(isset($channel['receivers'])) {

            $channel = $channel['receivers'];
        }
        else {

            $channel = null;
        }

        $params = $event->getCustomParams();
    }
}
