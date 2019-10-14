<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminLTE\Shell;

use AdminLTE\Shell\CronjobShell;
use Aura\Intl\Exception;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Prune Database Log Tables
 */
class PrunelogsShell extends CronjobShell
{
    public function main()
    {
        try {
            $tables = ConnectionManager::get('default')->schemaCollection()->listTables();

            foreach ($tables as $table) {

                if ($this->endswith($table, '_logs')) {

                    $date = (new \DateTime())->modify('-30 days');

                    $tableObject = TableRegistry::get($table);
                    $tableObject->deleteAll(['created < ' => $date->format('Y-m-d H:i:s')]);
                }
            }

            return 0;

        } catch (Exception $ex)
        {
            return -1;
        }
    }

    function endswith($string, $test) {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen) return false;
        return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
    }
}
