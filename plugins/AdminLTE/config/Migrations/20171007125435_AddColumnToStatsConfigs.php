<?php
use Migrations\AbstractMigration;

class AddColumnToStatsConfigs extends AbstractMigration
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
        $table = $this->table('stats_configs');
        $table->addColumn('where_column', 'string', [
            'default' => '',
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();
    }
}
