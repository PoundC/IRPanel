<?php
use Migrations\AbstractMigration;

class RenameOrders extends AbstractMigration
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
        $table->renameColumn('orderdesc', 'order_by');
        $table->renameColumn('timestamp', 'order_direction');
        $table->renameColumn('orderasc', 'created_or_modified');
        $table->update();
    }
}
