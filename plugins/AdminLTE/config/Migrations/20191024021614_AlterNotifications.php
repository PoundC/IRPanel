<?php
use Migrations\AbstractMigration;

class AlterNotifications extends AbstractMigration
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
        $table = $this->table('notifications');
        $table->addColumn('destination', 'enum', [
            'values' => [
                'Global',
                'Role',
                'User'
            ]
        ]);
        $table->addColumn('role_id', 'string', [
            'default' => '',
            'limit' => 32
        ]);
        $table->changeColumn('user_id', 'string', [
            'default' => '',
            'limit' => 36
        ]);
        $table->removeColumn('seen');
        $table->removeColumn('deleted');
        $table->update();

        $tableLogs = $this->table('admin_l_t_e_notification_logs');
        $tableLogs->addColumn('notification_id', 'integer');
        $tableLogs->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 36,
            'null' => false
        ]);
        $tableLogs->addColumn('created', 'datetime');
        $tableLogs->create();
    }
}
