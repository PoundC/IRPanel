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
    public function getConfigTable()
    {
        $table = TableRegistry::get('stats_configs');

        return $table;
    }

    public function getBasicsTable()
    {
        $table = TableRegistry::get('stats_basics');

        return $table;
    }

    public function getValuesTable()
    {
        $table = TableRegistry::get('stats_values');

        return $table;
    }
}