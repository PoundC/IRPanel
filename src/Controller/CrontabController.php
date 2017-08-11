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
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * User: jlroberts
 * Date: 8/10/17
 * Time: 6:45 PM
 */
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class CrontabController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function logs()
    {
        $cronJobTable = TableRegistry::get('cronjobs_crons');
        $cronJobQuery = $cronJobTable->find('all', ['contain' => ['cronjobs_logs']]);

        $tableAlias = $cronJobTable->getAlias();
        $this->set($tableAlias, $this->paginate($cronJobQuery));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);

        $this->set('title', 'View Cronjobs');
    }

    public function viewlogs($id)
    {
        $cronJobTable = TableRegistry::get('cronjobs_crons');
        $cronJobQuery = $cronJobTable->find('all')->where(['id' => $id]);
        $cronJobResult = $cronJobQuery->first();

        $boxTitle = $cronJobResult->get('name');

        $cronJobTable = TableRegistry::get('cronjobs_logs');
        $cronJobQuery = $cronJobTable->find('all')->where(['cronjobs_cron_id' => $id]);

        $tableAlias = $cronJobTable->getAlias();
        $this->set($tableAlias, $this->paginate($cronJobQuery));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);

        $this->set('boxTitle', $boxTitle);
        $this->set('title', 'View Cronjob Logs');
    }

    public function viewlog($id)
    {
        $cronJobTable = TableRegistry::get('cronjobs_logs');
        $cronJobQuery = $cronJobTable->find('all', ['contain' => ['cronjobs_crons']])->where(['cronjobs_logs.id' => $id]);
        $cronJobResult = $cronJobQuery->first();

        $this->set('title', 'View Cronjob Log');
        $this->set(compact('cronJobResult'));
    }

    public function status()
    {
        // check logs for negative -1 or errors output for not blank, if none return green, else red
    }
}