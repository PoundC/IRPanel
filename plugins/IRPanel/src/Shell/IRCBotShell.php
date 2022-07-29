<?php
namespace IRPanel\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use IRPanel\Utility\Database;
use Phergie\Irc\Client\React\WriteStream;
use Phergie\Irc\Connection;
use josegonzalez\Dotenv\Loader as SensitiveDataLoader;
use IRPanel\Logger\IRLogger;

/**
 * IRCBot shell command.
 */
class IRCBotShell extends Shell
{
    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        set_include_path(implode(PATH_SEPARATOR, array(
            get_include_path(),
            __DIR__ . '/../../../../',  // for vendor/bin when installed via Composer
        )));

        require __DIR__ . '/../../config/bootstrap.php';
        require __DIR__ . '/../../../../vendor/autoload.php';

        $this->loadModel('IRCUserIdents');

        // $this->IRCUserIdents->updateAll(['ident_ended' => new \DateTime('now')], ['ident_ended' => '']);

        $this->loadModel('Channels');

        $networks = Configure::read('networks');

        foreach($networks as $networkKey => $network)
        {
            $networkId = Database::getNetwork($networkKey);

            if($networkId == null)
            {
                $networkId = Database::insertNetwork($networkKey);
            }

            $serverId = Database::getServerId($network['server']);

            if($serverId == 0)
            {
                $serverId = Database::insertServer($networkId, $network['server'],
                    $network['port'], $network['server_password'], $network['oper_password'], $network['ssl']);
            }

            foreach($network['channels'] as $channel)
            {
                $channelId = Database::getChannelId($networkId, $channel);

                if($channelId == null)
                {
                    $channelId = Database::insertChannel($networkId, $channel);
                }
            }
        }

        $ircNetworks = array();

        foreach($networks as $networkKey => $network) {

            $ircNetworks[] =
                new Connection(array(
                    'serverHostname' => $network['server'],
                    'serverPort' => $network['port'],
                    'username' => $network['username'],
                    'realname' => $network['realname'],
                    'nickname' => $network['nickname'],
                    'password' => $network['server_password'],
                    'options' => $network['options']
                ));
        }

        $config = array(
            'connections' => $ircNetworks,
            'plugins' => array(
                new \Phergie\Irc\Plugin\React\AutoJoin\Plugin(['channels' => $network['channels']]),
                new \EnebeNb\Phergie\Plugin\AutoRejoin\Plugin(['channels' => $network['channels']]),
                new \Phergie\Irc\Plugin\React\Command\Plugin(['prefix' => '!']),
                new \Phergie\Irc\Plugin\React\JoinPart\Plugin(),
                new \Phergie\Irc\Plugin\React\Pong\Plugin(),
                new \IRPanel\Plugin(),
                new \IRPanelQuotes\Plugin(),
                new \IRPanelVoting\Plugin(),
                new \IRPanelVetting\Plugin(),
                new \IRPanelGame\Plugin(),
                new \IRPanelLinks\Plugin(),
                new \IRPanelMedia\Plugin(),
                new \IRPanelJams\Plugin()
            ),
            'logger' => new IRLogger()
        );

        $bot = new \Phergie\Irc\Bot\React\Bot;
        echo "Setting Config.\n";
        $bot->setConfig($config);
        $bot->getClient()->on('connect.after.each', function(\Phergie\Irc\ConnectionInterface $connection, \Phergie\Irc\Client\React\WriteStream $write) use ($network,$bot) {
            echo "Connect Start";
            $write->ircPrivmsg('UserServ', 'LOGIN IRBot ' . $network['userserv_password']);

            $timer = $bot->getClient()->addPeriodicTimer(45, function($timer) use ($bot, $connection, $write) {
                echo "Timer fired..\n";

                $nick = $connection->getNickname();

                echo "Foreach fired..$nick\n";

                $write->ircPrivmsg($nick, 'CTCP VERSION');
            });
        });
        $bot->getClient()->on('connect.end', function(\Phergie\Irc\ConnectionInterface $connection, \Psr\Log\LoggerInterface $logger) use ($bot) {
            $logger->debug('Connection to ' . $connection->getServerHostname() . ' lost, attempting to reconnect');
            sleep(5);
            $bot->getClient()->addConnection($connection);

            echo "Connect End";
        });
        $bot->getClient()->on('connect.error', function(\Phergie\Irc\ConnectionInterface $connection, \Psr\Log\LoggerInterface $logger) use ($bot) {
            $logger->debug('Connection to ' . $connection->getServerHostname() . ' lost, attempting to reconnect');
            sleep(30);
            $bot->getClient()->addConnection($connection);

            echo "Connect Error";
        });

        echo "Running..\n";

        $bot->run();
    }
}
