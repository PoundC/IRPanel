<?php
use Migrations\AbstractMigration;

class Cronjobs extends AbstractMigration
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
        $table = $this->table('cronjobs_crons');
        $table->addColumn('schedule', 'string', [
            'default' => null,
            'limit' => 128,
            'null' => false,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('command', 'string', [
            'default' => null,
            'limit' => 1024,
            'null' => false,
        ]);
        $table->addColumn('locked', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('timeout', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('lastrun', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('active', 'datetime', [
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

        $table = $this->table('cronjobs_logs');
        $table->addColumn('cronjobs_cron_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('success', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('output', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('error', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        $cronJobTable = \Cake\ORM\TableRegistry::get('cronjobs_crons');
        $cronJobsEntity = $cronJobTable->newEntity([
            'schedule' => '0 1 * * *',
            'name'     => 'Prune Database Log Tables',
            'command'  => 'prunelogs',
            'locked'   => 0,
            'timeout'  => 30,
            'lastrun'  => new \DateTime('now'),
            'active'  => new \DateTime('now'),
            'created'  => new \DateTime('now'),
            'modified'  => new \DateTime('now'),
        ]);
        $cronJobTable->save($cronJobsEntity);
    }
}
