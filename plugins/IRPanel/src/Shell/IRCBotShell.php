<?php
namespace IRPanel\Shell;

use Cake\Console\Shell;
use Phergie\Irc\Connection;
use josegonzalez\Dotenv\Loader as SensitiveDataLoader;

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

        $this->loadModel('Channels');

        SensitiveDataLoader::load([
            'filepath' => '.env',
            'expect' => [
                'POUNDC_PASSWORD',
            ],
            'toEnv' => true,
            'raiseExceptions' => false,
        ]);

        $config = array(
            'connections' => array(
                new Connection(array(
                    'serverHostname' => 'irc.poundc.com',
                    'serverPort' => 6697,
                    'username' => 'tmc',
                    'realname' => 'IRBot',
                    'nickname' => 'IRBot',
                    'password' => $_ENV['POUNDC_PASSWORD'],
                    'options' => array(
                        'transport' => 'ssl'
                    )
                ))
            ),
            'plugins' => array(
                new \Phergie\Irc\Plugin\React\AutoJoin\Plugin(['channels' => ['#cashmoney']]),
                new \Phergie\Irc\Plugin\React\Command\Plugin(['prefix' => '!']),
                new \Phergie\Irc\Plugin\React\JoinPart\Plugin(),
            )
        );

        $bot = new \Phergie\Irc\Bot\React\Bot;
        $bot->setConfig($config);
        $bot->run();
    }
}
