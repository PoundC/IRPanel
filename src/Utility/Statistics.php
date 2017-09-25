<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/23/17
 * Time: 12:20 PM
 */

namespace App\Utility;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class Statistics
{
    public function getLastTotalCount($stats_config_id)
    {
        $valuesTable = $this->getValuesTable();
        $valuesQuery = $valuesTable->find('all')->where(['stats_config_id' => $stats_config_id])->orderDesc('id')->limit(1);
        $valuesResult = $valuesQuery->first();

        return $valuesResult;
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