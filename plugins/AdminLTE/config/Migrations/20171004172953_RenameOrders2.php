<?php
use Migrations\AbstractMigration;

class RenameOrders2 extends AbstractMigration
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
        $table->renameColumn('order_direction', 'order_dir');
        $table->update();
    }
}
