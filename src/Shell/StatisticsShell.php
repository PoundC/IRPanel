<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/23/17
 * Time: 9:52 AM
 */

namespace App\Shell;

use Aura\Intl\Exception;
use Cake\ORM\TableRegistry;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Cake\Core\Configure;
use App\Utility\Users;
use App\Utility\Statistics;

/**
 * Create Statistics for Dashboards
 */
class StatisticsShell extends CronjobShell
{
    public function main()
    {
        try
        {
            $stats = new Statistics();
            $configTable = $stats->getConfigTable();
            $configQuery = $configTable->find('all');
            $statConfigs = $configQuery->all();

            foreach($statConfigs as $statConfig) {

                $configId = $statConfig->id;
                $table = $statConfig->stats_table;
                $column = $statConfig->stats_column;
                $type = $statConfig->stats_type;

                switch($type)
                {
                    case 'total_column':
                        $this->totalColumn($configId, $table, $column);
                        break;
                    case 'count_rows':
                        $this->countRows($configId, $table, $column);
                        break;
                }
            }
        }
        catch (Exception $ex)
        {
            print_r($ex);
            return -1;
        }
    }

    private function totalColumn($configId, $table, $column)
    {
        $stats = new Statistics();
        $valuesTable = $stats->getValuesTable();
        $tableObject = TableRegistry::get($table);

        $created = new \DateTime('now');
        $created = $created->format('Y-m-d H:i:s');

        $lastTotal = $valuesTable->find('all')->where(['stats_config_id' => $configId])->orderDesc(true)->limit(1);
        $lastTotalResult = $lastTotal->first();

        if(isset($lastTotalResult)) {

            $resultsQuery = $tableObject->find('all')->where([$table . '.created <=' => $created, $table . '.created >=' => $lastTotalResult->created]);
        }
        else {

            $resultsQuery = $tableObject->find('all')->where([$table . '.created <=' => $created, $table . '.created >=' => '0000-00-00 00:00:00']);
        }

        $results = $resultsQuery->all();

        $count = 0;
        $total = 0;

        foreach($results as $result)
        {
            $value = $result->get($column);
            $total = $total + $value;
            $count++;
        }

        // Retrieve order desc limit 1 total from values table
        $totalTotal = $lastTotalResult->total_total + $total;
        $totalCount = $lastTotalResult->total_count + $count;
        $growthRate = (round($total /  $count, 2) - $lastTotalResult->average) / $lastTotalResult->average;

        $averageQuery = $valuesTable->find('all')->where(['stats_config_id' => $configId]);
        $averagesList = $averageQuery->all();

        $avg = 0;
        $avg_total = 0;
        $avg_count = 0;
        $avg_growth_rate_total = 0;
        $avg_growth_rate_count = 0;
        $avg_growth_rate_avg = 0;
        foreach($averagesList as $averageRow) {

            $avg_total = $avg_total + $averageRow->interval_total;
            $avg_count++;
            $avg = $avg_total / $avg_count;
            $growth_rate = $averageRow->average - $avg / $avg;
            $avg_growth_rate_total = $avg_growth_rate_total + $growth_rate;
            $avg_growth_rate_count++;
            $avg_growth_rate_avg = $avg_growth_rate_total / $avg_growth_rate_count;
        }

        if(isset($lastTotalResult)) {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => round($total / $count, 2),
                'interval_growth_rate' => $total - $lastTotalResult->interval_total / $lastTotalResult->interval_total,
                'interval_growth_rate_avg' => $avg_growth_rate_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => round($totalTotal / $totalCount, 2),
                'total_growth_rate' => $totalTotal - $lastTotalResult->total_total / $lastTotalResult->total_total,
                'total_growth_rate_avg' => $avg_growth_rate_avg,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }
        else {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => round($total / $count, 2),
                'interval_growth_rate' => $total - 0 / 1,
                'interval_growth_rate_avg' => $avg_growth_rate_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => round($totalTotal / $totalCount, 2),
                'total_growth_rate' => $totalTotal - 0 / 1,
                'total_growth_rate_avg' => $avg_growth_rate_avg,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }

        print_r($valueEntity);

        $valuesTable->save($valueEntity);
    }

    private function countRows($configId, $table, $column)
    {
        $tableObject = TableRegistry::get($table);
    }
}
