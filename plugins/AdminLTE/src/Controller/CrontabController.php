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
namespace AdminLTE\Controller;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\View\Helper\BreadcrumbsHelper;

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
        $this->loadModel('AdminLTE.CronjobsCrons');

        $cronJobQuery = $this->CronjobsCrons->find('all', ['contain' => ['CronjobsLogs']]);

        $tableAlias = $this->CronjobsCrons->getAlias();
        $this->set($tableAlias, $this->paginate($cronJobQuery));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);

        $this->set('title', 'View Cronjobs');
    }

    public function viewlogs($id)
    {
        $this->loadModel('AdminLTE.CronjobsCrons');
        $this->loadModel('AdminLTE.CronjobsLogs');

        $cronJobQuery = $this->CronjobsCrons->find('all')->where(['id' => $id]);
        $cronJobResult = $cronJobQuery->first();

        $boxTitle = $cronJobResult->get('name');

        $cronJobQuery = $this->CronjobsLogs->find('all')->where(['cronjobs_cron_id' => $id]);

        $tableAlias = $this->CronjobsLogs->getAlias();
        $this->set($tableAlias, $this->paginate($cronJobQuery));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);

        $this->set('boxTitle', $boxTitle);
        $this->set('title', 'View Cronjob Logs');
    }

    public function viewlog($id)
    {
        $this->loadModel('AdminLTE.CronjobsLogs');

        $cronJobQuery = $this->CronjobsLogs->find('all', ['contain' => ['CronjobsCrons']])->where(['CronjobsLogs.id' => $id]);
        $cronJobResult = $cronJobQuery->first();

        $this->set('title', 'View Cronjob Log');
        $this->set(compact('cronJobResult'));
    }

    public function status()
    {
        // check logs for negative -1 or errors output for not blank, if none return green, else red
    }
}
