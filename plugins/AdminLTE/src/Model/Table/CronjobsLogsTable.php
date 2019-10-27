<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * CronjobsLogs Model
 */
class CronjobsLogsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('cronjobs_crons', ['className' => 'AdminLTE\Model\Table\CronjobsCronsTable'])->setForeignKey('cronjobs_cron_id')->setProperty('crontab');

        $this->setTable('admin_l_t_e_cronjobs_logs');
        $this->setDisplayField('success');
        $this->setPrimaryKey('id');
    }
}
