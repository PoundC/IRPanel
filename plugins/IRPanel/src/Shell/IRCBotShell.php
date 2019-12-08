<?php
namespace IRPanel\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
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

        require __DIR__ . '/../../../../vendor/autoload.php';

        $this->loadModel('IRCUserIdents');

        // $this->IRCUserIdents->updateAll(['ident_ended' => new \DateTime('now')], ['ident_ended' => '']);

        $this->loadModel('Channels');

        $networks = Configure::read('networks');

        foreach($networks as $networkKey => $network) {

            $config = array(
                'connections' => array(
                    new Connection(array(
                        'serverHostname' => $network['server'],
                        'serverPort' => $network['port'],
                        'username' => $network['username'],
                        'realname' => $network['realname'],
                        'nickname' => $network['nickname'],
                        'password' => $network['server_password'],
                        'options' => $network['options']
                    ))
                ),
                'plugins' => array(
                    new \Phergie\Irc\Plugin\React\AutoJoin\Plugin(['channels' => ['#c', '#cashmoney']]), // $network['channels']]),
                    new \EnebeNb\Phergie\Plugin\AutoRejoin\Plugin(['channels' => ['#c', '#cashmoney']]), // $network['channels']]),
                    new \Phergie\Irc\Plugin\React\Command\Plugin(['prefix' => '!']),
                    new \Phergie\Irc\Plugin\React\JoinPart\Plugin(),
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
            $bot->setConfig($config);
            $bot->getClient()->on('connect.after.each', function(\Phergie\Irc\ConnectionInterface $connection, \Phergie\Irc\Client\React\WriteStream $write) use ($network) {
                $write->ircPrivmsg('UserServ', 'LOGIN IRBot ' . $network['userserv_password']);
            });
            $bot->getClient()->on('connect.end', function(\Phergie\Irc\ConnectionInterface $connection, \Psr\Log\LoggerInterface $logger) use ($bot) {
                $logger->debug('Connection to ' . $connection->getServerHostname() . ' lost, attempting to reconnect');
                sleep(5);
                $bot->getClient()->addConnection($connection);
            });
            $bot->getClient()->on('connect.error', function(\Phergie\Irc\ConnectionInterface $connection, \Psr\Log\LoggerInterface $logger) use ($bot) {
                $logger->debug('Connection to ' . $connection->getServerHostname() . ' lost, attempting to reconnect');
                sleep(30);
                $bot->getClient()->addConnection($connection);
            });
            $bot->run();
        }
    }
}
