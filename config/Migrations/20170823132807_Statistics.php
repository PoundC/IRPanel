<?php
use Migrations\AbstractMigration;

class Statistics extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->createStatsConfig();
        $this->createStatsValues();
        $this->insertBasicConfig();
        $this->createCronjob();
    }

    private function createStatsConfig()
    {
        $table = $this->table('stats_configs');
        $table->addColumn('stats_table', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('stats_column', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('stats_type', 'string', [
            'default' => 'count_rows', // or total_column
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }

    private function createStatsValues()
    {
        $table = $this->table('stats_values');
        $table->addColumn('stats_config_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('interval_total', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('interval_count', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('interval_average', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('interval_growth_rate', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('interval_growth_rate_avg', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_total', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_count', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_average', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_growth_rate', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('total_growth_rate_avg', 'float', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }

    private function insertBasicConfig()
    {
        $statsConfigTable = \Cake\ORM\TableRegistry::get('stats_configs');

        // New User Stats
        $statsConfigEntity = $statsConfigTable->newEntity([
            'stats_table'      => 'users',
            'stats_column'     => 'id',
            'stats_type' => 'count_rows',
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $statsConfigTable->save($statsConfigEntity);

        // New Support Request Stats
        $statsConfigEntity = $statsConfigTable->newEntity([
            'stats_table'      => 'messages',
            'stats_column'     => 'id',
            'stats_type' => 'count_rows',
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $statsConfigTable->save($statsConfigEntity);

        // Support Chats Stats
        $statsConfigEntity = $statsConfigTable->newEntity([
            'stats_table'      => 'chatrooms',
            'stats_column'     => 'id',
            'stats_type' => 'count_rows',
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $statsConfigTable->save($statsConfigEntity);

        // Support Room Stats
        $statsConfigEntity = $statsConfigTable->newEntity([
            'stats_table'      => 'chats',
            'stats_column'     => 'id',
            'stats_type' => 'count_rows',
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $statsConfigTable->save($statsConfigEntity);

        // New Subscription Stats
        $statsConfigEntity = $statsConfigTable->newEntity([
            'stats_table'      => 'users_subscriptions',
            'stats_column'     => 'id',
            'stats_type' => 'count_rows',
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $statsConfigTable->save($statsConfigEntity);

        // Subscription Revenue Stats
        $statsConfigEntity = $statsConfigTable->newEntity([
            'stats_table'      => 'users_subscriptions',
            'stats_column'     => 'price',
            'stats_type' => 'total_column',
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $statsConfigTable->save($statsConfigEntity);
    }

    private function createCronjob()
    {
        $cronJobTable = \Cake\ORM\TableRegistry::get('cronjobs_crons');
        $cronJobsEntity = $cronJobTable->newEntity([
            'schedule' => '0 0 * * *',
            'name'     => 'Basic Database Statistics',
            'command'  => 'statistics',
            'locked'   => 0,
            'timeout'  => 0,
            'lastrun'  => new \DateTime('now'),
            'active'  => new \DateTime('now'),
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $cronJobTable->save($cronJobsEntity);
    }
}
