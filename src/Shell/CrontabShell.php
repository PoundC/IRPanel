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
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Psy\Shell as PsyShell;

/**
 * Simple Crontab
 */
class CrontabShell extends Shell
{

    public function main()
    {
        $shell = new Shell();

        $crontabTable = TableRegistry::get('cronjobs_crons');
        $crontabQuery = $crontabTable->find('all');
        $crontabResults = $crontabQuery->all();

        $crontabHelper = $this->helper('Crontab');

        foreach($crontabResults as $cronJob) {

            $now = new \DateTime('now');

            $isDue = $crontabHelper->due($cronJob->lastrun->format('Y-m-d H:i:s'), $now->format('Y-m-d H:i:s'), $cronJob->schedule);

            if($isDue == true) {

                $result = $shell->dispatchShell([
                    'command' => $cronJob->command . ' execute ' . $cronJob->id,
                    'extra' => []
                ]);
            }
        }
    }
}