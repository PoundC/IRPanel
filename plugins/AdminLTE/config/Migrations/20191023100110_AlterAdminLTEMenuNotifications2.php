<?php
use Migrations\AbstractMigration;

class AlterAdminLTEMenuNotifications2 extends AbstractMigration
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
        $table->changeColumn('user_id', 'string', [
            'default' => '',
            'limit' => 64
        ]);
        $table->update();

        $table = $this->table('admin_l_t_e_menu_notification_logs');
        $table->changeColumn('user_id', 'string', [
            'default' => '',
            'limit' => 64
        ]);
        $table->update();
    }
}
