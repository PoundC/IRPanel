<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/23/17
 * Time: 12:20 PM
 */

namespace AdminLTE\Utility;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class Statistics
{
    public function getLastTotalCount($stats_table)
    {
        $configTable = $this->getConfigTable();
        $configQuery = $configTable->find('all')->where(['stats_table' => $stats_table])->orderDesc('id')->limit(1);
        $configValue = $configQuery->first();

        $stats_config_id = $configValue->id;

        $valuesTable = $this->getValuesTable();
        $valuesQuery = $valuesTable->find('all')->where(['stats_config_id' => $stats_config_id])->orderDesc('id')->limit(1);
        $valuesResult = $valuesQuery->first();

        return $valuesResult->get('total_count');
    }

    public function getConfigTable()
    {
        $table = TableRegistry::get('stats_configs');

        return $table;
    }

    public function getValuesTable()
    {
        $table = TableRegistry::get('stats_values');

        return $table;
    }
}
