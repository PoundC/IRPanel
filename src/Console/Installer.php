<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Console;

require_once(__DIR__ . '/../../vendor/autoload.php');

use Cake\Console\Shell;
use Cake\Utility\Security;
use Composer\Script\Event;
use Exception;
use Cake\Console\ShellDispatcher;

/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */
class Installer
{

    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @throws \Exception Exception raised by validator.
     * @return void
     */
    public static function postInstall(Event $event)
    {
        $io = $event->getIO();

        $rootDir = dirname(dirname(__DIR__));

        $validator = function ($arg) {
            if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                return $arg;
            }
            throw new Exception('This is not a valid answer. Please choose Y or n.');
        };

        static::createAppConfig($rootDir, $io);
        static::createWritableDirectories($rootDir, $io);
        static::createAdminLTESymLinks($event);

        // ask if the permissions should be changed
        if ($io->isInteractive()) {

            $setFolderPermissions = $io->askAndValidate(
                '<info>Set Folder Permissions? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                $validator,
                10,
                'Y'
            );

            if (in_array($setFolderPermissions, ['Y', 'y'])) {
                static::setFolderPermissions($rootDir, $io);
            }
        } else {
            static::setFolderPermissions($rootDir, $io);
        }

        static::setSecuritySalt($rootDir, $io);

        $bakeDatabaseConfig = $io->askAndValidate(
            '<info>Enter Database Config? (Default to Y)</info> [<comment>Y,n</comment>]? ',
            $validator,
            10,
            'Y'
        );

        require_once(__DIR__ . '/../../config/bootstrap.php');

        $shellDispatcher = new ShellDispatcher();
        $shell = new Shell();

        if (in_array($bakeDatabaseConfig, ['Y', 'y'])) {

            static::setDatabaseDetails($rootDir, $io, $shell);

            $installSchemas = $io->askAndValidate(
                '<info>Install Default Schemas? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                $validator,
                10,
                'Y'
            );

            if (in_array($installSchemas, ['Y', 'y'])) {

                $shellDispatcher->dispatch([
                    'command' => 'migrations migrate --plugin CakePHPKitchen/CakeAdminUsers',
                    'extra' => []
                ]);

                $addSuperUser = $io->askAndValidate(
                    '<info>Add Superuser to database? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                    $validator,
                    10,
                    'Y'
                );

                if (in_array($addSuperUser, ['Y', 'y'])) {

                    $shellDispatcher->dispatch([
                        'command' => 'users addSuperuser',
                        'extra' => []
                    ]);
                }
            }
        }

        if (class_exists('\Cake\Codeception\Console\Installer')) {
            \Cake\Codeception\Console\Installer::customizeCodeceptionBinary($event);
        }
    }

    /**
     * Create the config/app.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createAppConfig($dir, $io)
    {
        $appConfig = $dir . '/config/app.php';
        $defaultConfig = $dir . '/config/app.default.php';
        if (!file_exists($appConfig)) {
            copy($defaultConfig, $appConfig);
            $io->write('Created `config/app.php` file');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createWritableDirectories($dir, $io)
    {
        $paths = [
            'logs',
            'tmp',
            'tmp/cache',
            'tmp/cache/models',
            'tmp/cache/persistent',
            'tmp/cache/views',
            'tmp/sessions',
            'tmp/tests'
        ];

        foreach ($paths as $path) {
            $path = $dir . '/' . $path;
            if (!file_exists($path)) {
                mkdir($path);
                $io->write('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setFolderPermissions($dir, $io)
    {
        // Change the permissions on a path and output the results.
        $changePerms = function ($path, $perms, $io) {
            // Get permission bits from stat(2) result.
            $currentPerms = fileperms($path) & 0777;
            if (($currentPerms & $perms) == $perms) {
                return;
            }

            $res = chmod($path, $currentPerms | $perms);
            if ($res) {
                $io->write('Permissions set on ' . $path);
            } else {
                $io->write('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir, $perms, $io) use (&$walker, $changePerms) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;

                if (!is_dir($path)) {
                    continue;
                }

                $changePerms($path, $perms, $io);
                $walker($path, $perms, $io);
            }
        };

        $worldWritable = bindec('0000000111');
        $walker($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/logs', $worldWritable, $io);
    }

    /**
     * Set the security.salt value in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setSecuritySalt($dir, $io)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $newKey = hash('sha256', Security::randomBytes(64));
        $content = str_replace('__SALT__', $newKey, $content, $count);

        if ($count == 0) {
            $io->write('No Security.salt placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated Security.salt value in config/app.php');

            return;
        }
        $io->write('Unable to update Security.salt value.');
    }


    public static function setDatabaseDetails($dir, $io, $shell)
    {
        static::setDatabaseHost($dir, $io, $shell);
        static::setDatabasePort($dir, $io, $shell);
        static::setDatabaseName($dir, $io, $shell);
        static::setDatabaseUsername($dir, $io, $shell);
        static::setDatabasePassword($dir, $io, $shell);
    }

    /**
     *
     * Set the database details in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setDatabaseName($dir, $io, $shell)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databaseName = $shell->in('Enter the database name: ');

        $content = str_replace("'database' => 'my_app',", "'database' => '" . $databaseName . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database value in config/app.php');

            return;
        }
        $io->write('Unable to update database value.');
    }

    public static function setDatabasePort($dir, $io, $shell)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databasePort = $shell->in('Enter the database port: ', null, 3306);

        $content = str_replace("//'port' => 'non_standard_port_number',", "'port' => '" . $databasePort . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database port placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database port value in config/app.php');

            return;
        }
        $io->write('Unable to update database port value.');
    }

    public static function setDatabaseUsername($dir, $io, $shell)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databaseUsername = $shell->in('Enter the database username: ');

        $content = str_replace("'username' => 'my_app',", "'username' => '" . $databaseUsername . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database username placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database username value in config/app.php');

            return;
        }
        $io->write('Unable to update database username value.');
    }

    public static function setDatabasePassword($dir, $io, $shell)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databasePass = $shell->in('Enter the database user password: ');

        $content = str_replace("'password' => 'secret',", "'password' => '" . $databasePass . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database password placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database password value in config/app.php');

            return;
        }
        $io->write('Unable to update password database value.');
    }


    public static function setDatabaseHost($dir, $io, $shell)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databaseHost = $shell->in('Enter the database host: ', null, '127.0.0.1');

        $content = str_replace("'host' => 'localhost',", "'host' => '" . $databaseHost . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database host placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database host value in config/app.php');

            return;
        }
        $io->write('Unable to update host database value.');
    }

    public static function createAdminLTESymLinks(Event $event)
    {
        $io = $event->getIO();

        $rootDir = dirname(dirname(__DIR__));

        $io->write('Installing AdminLTE vendor SymLinks to Webroot');

        try {
            symlink($rootDir . '/vendor/almasaeed2010/adminlte/bootstrap', $rootDir . '/webroot/bootstrap');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/bootstrap');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/dist', $rootDir . '/webroot/dist');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/dist');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/documentation', $rootDir . '/webroot/documentation');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/documentation');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/pages', $rootDir . '/webroot/pages');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/pages');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/plugins', $rootDir . '/webroot/plugins');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/plugins');
        }
        catch(Exception $ex)
        {

        }
        return 0;
    }
}
