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
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOutput;

/**
 * Simple Test Crontab
 */
abstract class CronjobShell extends Shell
{
    public $cronJobId;

    public $result = 0;

    public $rootLogsDirectory = ROOT . DS . 'tmp' . DS . 'logs';
    public $outputName;

    public function __construct() {

        $this->outputName = tempnam($this->rootLogsDirectory, 'cronjobs');

        $stdout = new ConsoleOutput('file://' . $this->outputName . '.out');
        $stderr = new ConsoleOutput('file://' . $this->outputName . '.err');

        $ioNew = new ConsoleIo($stdout, $stderr);

        parent::__construct($ioNew);
    }

    public abstract function main();

    public function execute($id = 0)
    {
        if($id != 0) {

            $this->cronJobId = $id;
        }
        else {

            $this->out('Exiting, no Id Passed as Parameter');
        }

        if($this->isLocked() && $this->isTimedOut()) {

            $this->resetTimedout();
        }

        if($this->isLocked())
        {
            $this->err('Cronjob is Locked');
            $this->result = -1;
            $this->logger();

            return false;
        }

        $this->lock();
        $this->active();

        $this->result = $this->main();

        $this->lastrun();
        $this->logger();
        $this->unlock();
    }

    public function logger()
    {
        $crontabLogTable = TableRegistry::get('cronjobs_logs');

        $crontabLogEntity = $crontabLogTable->newEntity([
            'cronjobs_cron_id' => $this->cronJobId,
            'success' => $this->result,
            'output' => file_get_contents($this->outputName . '.out'),
            'error' => file_get_contents($this->outputName . '.err'),
            'created' => new \DateTime('now')
        ]);

        $crontabLogTable->save($crontabLogEntity);

        unlink($this->outputName);
        unlink($this->outputName . '.out');
        unlink($this->outputName . '.err');
    }

    public function resetTimedout()
    {
        $this->setCronJobProperty('locked', 0);
    }

    public function isLocked()
    {
        $cronJobResult = $this->getCronJob($this->cronJobId);

        if($cronJobResult->get('locked') == 1) {

            return true;
        }
        else {

            return false;
        }
    }

    public function isTimedOut()
    {
        $cronJobResult = $this->getCronJob($this->cronJobId);

        $active = $cronJobResult->get('active');
        $timeoutIncrement = $cronJobResult->get('timeout');

        if ($timeoutIncrement == '0' || $timeoutIncrement == 0)
        {
            return false;
        }

        $lastActive = strtotime($active);
        $now = strtotime('now');

        $diff = $now - $lastActive;

        $timeoutIncrementAdjusted = $timeoutIncrement * 60;

        if($diff > $timeoutIncrementAdjusted) {

            return true;
        }
        else {

            return false;
        }
    }

    public function lock()
    {
        $this->setCronJobProperty('locked', 1);
    }

    public function unlock()
    {
        $this->setCronJobProperty('locked', 0);
    }

    public function lastrun()
    {
        $timestamp = new \DateTime('now');

        $this->setCronJobProperty('lastrun', $timestamp);
    }

    public function active()
    {
        $timestamp = new \DateTime('now');

        $this->setCronJobProperty('active', $timestamp);
    }

    public function setCronJobProperty($property, $value)
    {
        $cronJobResult = $this->getCronJob($this->cronJobId);

        $cronJobResult->set($property, $value);

        $this->saveCronJob($cronJobResult);
    }

    public function getCronJob($id)
    {
        $cronJobTable = TableRegistry::get('cronjobs_crons');
        $cronJobQuery = $cronJobTable->find('all')->where(['cronjobs_crons.id' => $this->cronJobId]);
        $cronJobResult = $cronJobQuery->first();

        return $cronJobResult;
    }

    public function saveCronJob($cronJobEntity)
    {
        $cronJobTable = TableRegistry::get('cronjobs_crons');

        $cronJobTable->save($cronJobEntity);
    }
}