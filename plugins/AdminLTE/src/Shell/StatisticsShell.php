<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/23/17
 * Time: 9:52 AM
 */

namespace AdminLTE\Shell;

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
                $where_column = $statConfig->where_column;
                $equals = $statConfig->equals;
                $order_by = $statConfig->order_by;
                $order_dir = $statConfig->order_dir;
                $created_or_modified = $statConfig->created_or_modified;

                switch($type)
                {
                    case 'total_column':
                        $this->totalColumn($configId, $table, $column);
                        break;
                    case 'count_rows':
                        $this->countRows($configId, $table, $column);
                        break;
                    case 'count_rows_where':
                        $this->countRowsWhere($configId, $table, $column, $equals, $created_or_modified);
                        break;
                    case 'collect_last_column':
                        $this->collectLastColumn($configId, $table, $column, $order_by, $order_dir);
                        break;
                    case 'collect_last_column_where':
                        $this->collectLastColumnWhere($configId, $table, $column, $where_column, $equals, $order_by, $order_dir);
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

            $lastCreated = $lastTotalResult->created;
        }
        else {

            $lastCreated = '0000-00-00 00:00:00';
        }

        $resultsQuery = $tableObject->find('all')->where([$table . '.created <=' => $created, $table . '.created >=' => $lastCreated]);

        $results = $resultsQuery->all();

        $count = 0;
        $total = 0;

        foreach($results as $result)
        {
            $value = $result->get($column);
            $total = $total + $value;
            $count++;
        }

        if(isset($lastTotalResult) && $lastTotalResult->total_total > 0) {

            $totalTotal = $lastTotalResult->total_total + $total;
            $totalCount = $lastTotalResult->total_count + $count;

            $growthRate = ($total - $lastTotalResult->total_total) / $lastTotalResult->total_total;
        }
        else {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = 0;
        }

        if($count > 0) {
            $interval_avg = round($total / $count, 2);
        }
        else {
            $interval_avg = 0;
        }

        if($count > 0) {
            $total_average = round($total / $count, 2);
        }
        else {
            $total_average = 0;
        }

        if(isset($lastTotalResult)) {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => $growthRate,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }
        else {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => 1,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }

        $valuesTable->save($valueEntity);
    }

    private function countRowsWhereNot($configId, $table, $column, $equals)
    {
        $stats = new Statistics();
        $valuesTable = $stats->getValuesTable();
        $tableObject = TableRegistry::get($table);

        $created = new \DateTime('now');
        $created = $created->format('Y-m-d H:i:s');

        $lastTotal = $valuesTable->find('all')->where(['stats_config_id' => $configId])->orderDesc('id')->limit(1);
        $lastTotalResult = $lastTotal->first();

        if(isset($lastTotalResult)) {
            $lastCreated = $lastTotalResult->created;
        }
        else {
            $lastCreated = '0000-00-00 00:00:00';
        }

        $resultsQuery = $tableObject->find('all')->where([$table . '.created <=' => $created, $table . '.created >=' => $lastCreated, $column . ' <>' => $equals]);
        $count = $resultsQuery->count();
        $total = $count;

        if(isset($lastTotalResult) && $lastTotalResult->total_total > 0) {

            $totalTotal = $lastTotalResult->total_total + $total;
            $totalCount = $lastTotalResult->total_count + $count;

            $growthRate = ($total - $lastTotalResult->total_total) / $lastTotalResult->total_total;
        }
        else {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = 0;
        }

        if($count > 0) {
            $interval_avg = round($total / $count, 2);
        }
        else {
            $interval_avg = 0;
        }

        if($count > 0) {
            $total_average = round($total / $count, 2);
        }
        else {
            $total_average = 0;
        }

        if(isset($lastTotalResult)) {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => $growthRate,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }
        else {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => 1,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }

        $valuesTable->save($valueEntity);
    }

    private function countRowsWhere($configId, $table, $column, $equals, $created_or_modified)
    {
        $stats = new Statistics();
        $valuesTable = $stats->getValuesTable();
        $tableObject = TableRegistry::get($table);

        $created = new \DateTime('now');
        $created = $created->format('Y-m-d H:i:s');

        $lastTotal = $valuesTable->find('all')->where(['stats_config_id' => $configId])->orderDesc('id')->limit(1);
        $lastTotalResult = $lastTotal->first();

        if(isset($lastTotalResult)) {
            $lastCreated = $lastTotalResult->created;
        }
        else {
            $lastCreated = '0000-00-00 00:00:00';
        }

        $resultsQuery = $tableObject->find('all')->where([$table . '.' . $created_or_modified . ' <=' => $created, $table . '.' . $created_or_modified . ' >=' => $lastCreated, $column => $equals]);
        $count = $resultsQuery->count();
        $total = $count;

        if(isset($lastTotalResult) && $lastTotalResult->total_total > 0) {

            $totalTotal = $lastTotalResult->total_total + $total;
            $totalCount = $lastTotalResult->total_count + $count;

            $growthRate = ($total - $lastTotalResult->total_total) / $lastTotalResult->total_total;
        }
        else {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = 0;
        }

        if($count > 0) {
            $interval_avg = round($total / $count, 2);
        }
        else {
            $interval_avg = 0;
        }

        if($count > 0) {
            $total_average = round($total / $count, 2);
        }
        else {
            $total_average = 0;
        }

        if(isset($lastTotalResult)) {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => $growthRate,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }
        else {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => 1,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }

        $valuesTable->save($valueEntity);
    }

    private function collectLastColumn($configId, $table, $column, $order_by, $order_dir)
    {
        $stats = new Statistics();
        $valuesTable = $stats->getValuesTable();
        $tableObject = TableRegistry::get($table);

        $created = new \DateTime('now');
        $created = $created->format('Y-m-d H:i:s');

        $lastTotal = $valuesTable->find('all')->where(['stats_config_id' => $configId])->orderDesc('id')->limit(1);
        $lastTotalResult = $lastTotal->first();

        if($order_dir == 'desc') {
            $resultsQuery = $tableObject->find('all')->orderDesc($order_by)->limit(1);
        }
        else {
            $resultsQuery = $tableObject->find('all')->orderAsc($order_by)->limit(1);
        }
        $results = $resultsQuery->first();

        if(!$results) {
            $count = 0;
        }
        else {
            $count = $results->get($column);
        }
        $total = $count;

        if(isset($lastTotalResult) && $lastTotalResult->total_total > 0) {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = ($total - $lastTotalResult->total_total) / $lastTotalResult->total_total;
        }
        else {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = 0;
        }

        if($count > 0) {
            $interval_avg = round($total / $count, 2);
        }
        else {
            $interval_avg = 0;
        }

        if($count > 0) {
            $total_average = round($total / $count, 2);
        }
        else {
            $total_average = 0;
        }

        if(isset($lastTotalResult)) {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => $growthRate,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }
        else {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => 1,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }

        $valuesTable->save($valueEntity);
    }

    private function collectLastColumnWhere($configId, $table, $column, $where_column, $equals, $order_by, $order_dir)
    {
        $stats = new Statistics();
        $valuesTable = $stats->getValuesTable();
        $tableObject = TableRegistry::get($table);

        $created = new \DateTime('now');
        $created = $created->format('Y-m-d H:i:s');

        $lastTotal = $valuesTable->find('all')->where(['stats_config_id' => $configId])->orderDesc('id')->limit(1);
        $lastTotalResult = $lastTotal->first();

        if($order_dir == 'desc') {
            $resultsQuery = $tableObject->find('all')->where([$where_column => $equals])->orderDesc($order_by)->limit(1);
        }
        else {
            $resultsQuery = $tableObject->find('all')->where([$where_column => $equals])->orderAsc($order_by)->limit(1);
        }
        $results = $resultsQuery->first();

        if(!$results) {
            $count = 0;
        }
        else {
            $count = $results->get($column);
        }
        $total = $count;

        if(isset($lastTotalResult) && $lastTotalResult->total_total > 0) {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = ($total - $lastTotalResult->total_total) / $lastTotalResult->total_total;
        }
        else {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = 0;
        }

        if($count > 0) {
            $interval_avg = round($total / $count, 2);
        }
        else {
            $interval_avg = 0;
        }

        if($count > 0) {
            $total_average = round($total / $count, 2);
        }
        else {
            $total_average = 0;
        }

        if(isset($lastTotalResult)) {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => $growthRate,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }
        else {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => 1,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }

        $valuesTable->save($valueEntity);
    }

    //@todo: Count Row Statistics && DB
    private function countRows($configId, $table, $column)
    {
        $stats = new Statistics();
        $valuesTable = $stats->getValuesTable();
        $tableObject = TableRegistry::get($table);

        $created = new \DateTime('now');
        $created = $created->format('Y-m-d H:i:s');

        $lastTotal = $valuesTable->find('all')->where(['stats_config_id' => $configId])->orderDesc('id')->limit(1);
        $lastTotalResult = $lastTotal->first();

        if(isset($lastTotalResult)) {
            $lastCreated = $lastTotalResult->created;
        }
        else {
            $lastCreated = '0000-00-00 00:00:00';
        }

        $resultsQuery = $tableObject->find('all')->where([$table . '.created <=' => $created, $table . '.created >=' => $lastCreated]);
        $count = $resultsQuery->count();
        $total = $count;

        if(isset($lastTotalResult) && $lastTotalResult->total_total > 0) {

            $totalTotal = $lastTotalResult->total_total + $total;
            $totalCount = $lastTotalResult->total_count + $count;

            $growthRate = ($total - $lastTotalResult->total_total) / $lastTotalResult->total_total;
        }
        else {

            $totalTotal = $total;
            $totalCount = $count;

            $growthRate = 0;
        }

        if($count > 0) {
            $interval_avg = round($total / $count, 2);
        }
        else {
            $interval_avg = 0;
        }

        if($count > 0) {
            $total_average = round($total / $count, 2);
        }
        else {
            $total_average = 0;
        }

        if(isset($lastTotalResult)) {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => $growthRate,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }
        else {

            $valueEntity = $valuesTable->newEntity([
                'stats_config_id' => $configId,
                'interval_total' => $total,
                'interval_count' => $count,
                'interval_average' => $interval_avg,
                'total_total' => $totalTotal,
                'total_count' => $totalCount,
                'total_average' => $total_average,
                'total_growth_rate' => 1,
                'created' => $created,
                'modified' => new \DateTime('now')
            ]);
        }

        $valuesTable->save($valueEntity);
    }
}
