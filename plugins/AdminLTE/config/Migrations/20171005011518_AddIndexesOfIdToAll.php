<?php
use Migrations\AbstractMigration;

class AddIndexesOfIdToAll extends AbstractMigration
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
        $table = $this->table('stats_values');
        $table->addIndex(['stats_config_id']);
        $table->save();
    }
}
