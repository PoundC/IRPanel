<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Plugin;

/**
 * UpdateMigrations shell command.
 */
class UpdateMigrationsShell extends Shell
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
        $shell = new Shell();

        $shell->dispatchShell([
            'command' => 'Migrations.migrations migrate',
            'extra' => []
        ]);

        $shell->dispatchShell([
            'command' => 'migrations.migrations migrate --plugin AdminLTE',
            'extra' => []
        ]);

        $loadedPluings = array_reverse(Plugin::loaded());

        foreach($loadedPluings as $plugin) {

            if($plugin != 'DebugKit' && $plugin != 'DBFixes' && $plugin != 'AdminLTE') {

                $shell->dispatchShell([
                    'command' => 'migrations.migrations migrate --plugin ' . $plugin,
                    'extra' => []
                ]);
            }
        }

        $shell->dispatchShell([
            'command' => 'migrations.migrations migrate --plugin DBFixes',
            'extra' => []
        ]);
    }
}
