<?php
use Migrations\AbstractMigration;

class CreateAdminLTEPushNotifications extends AbstractMigration
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
        $table = $this->table('admin_l_t_e_push_notifications');
        $table->addColumn('notification_id', 'integer');
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 36,
            'null' => false
        ]);
        $table->addColumn('created', 'datetime');
        $table->create();

        $table->addIndex('notification_id');
        $table->addIndex('user_id');
        $table->addIndex(['notification_id', 'user_id']);
    }
}
