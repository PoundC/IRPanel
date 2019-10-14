<?php
use Migrations\AbstractMigration;

class CreateNotifications extends AbstractMigration
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
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 36,
            'null'    => false
        ]);
        $table->addColumn('type', 'string', [
            'default' => '',
            'limit'   => 32,
            'null'    => false
        ]);
        $table->addColumn('message', 'string', [
            'default' => '',
            'limit'   => 1024,
            'null'    => false
        ]);
        $table->addColumn('seen', 'integer', [
            'default' => 0,
            'null'    => false
        ]);
        $table->addColumn('deleted', 'integer', [
            'default' => 0,
            'null'    => false
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
