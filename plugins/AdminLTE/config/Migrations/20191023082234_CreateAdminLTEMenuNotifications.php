<?php
use Migrations\AbstractMigration;

class CreateAdminLTEMenuNotifications extends AbstractMigration
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
        $table->addColumn('menu_group', 'string', [
            'default' => null,
            'limit' => 32,
            'null' => false
        ]);
        $table->addColumn('menu_title', 'string', [
            'default' => null,
            'limit' => 32,
            'null' => false
        ]);
        $table->addColumn('notification_count', 'integer');
        $table->addColumn('destination', 'enum', [
            'default' => null,
            'null' => false,
            'values' => [
                'Global',
                'Role',
                'User'
            ]
        ]);
        $table->addColumn('destination_id' , 'string', [
            'default' => null,
            'limit' => 16,
            'null' => false
        ]);
        $table->create();

        $tableLogs = $this->table('admin_l_t_e_menu_notification_logs');
        $tableLogs->addColumn('admin_l_t_e_menu_notification_id', 'integer');
        $tableLogs->addColumn('user_id', 'integer');
        $tableLogs->addColumn('created', 'datetime');
        $tableLogs->create();

    }
}
