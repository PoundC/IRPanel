<?php
use Migrations\AbstractMigration;

class AlterAdminLTEMenuNotifications extends AbstractMigration
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
        $table = $this->table('admin_l_t_e_menu_notifications');
        $table->addColumn('user_id', 'integer');
        $table->addColumn('role_id', 'string', [
            'default' => '',
            'limit' => 16
        ]);
        $table->removeColumn('destination_id');
        $table->update();
    }
}
