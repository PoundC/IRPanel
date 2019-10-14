<?php
use Migrations\AbstractMigration;

class RenameOrderBytoOrderDesc extends AbstractMigration
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
        $table->renameColumn('orderby', 'orderdesc');
        $table->addColumn('orderasc', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();
    }
}
