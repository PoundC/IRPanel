<?php
use Migrations\AbstractMigration;

class CreateAdminLTETasks extends AbstractMigration
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
        $table = $this->table('admin_l_t_e_tasks');
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 36,
            'null' => false
        ]);
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 256,
            'null' => false
        ]);
        $table->addColumn('message', 'text');
        $table->addColumn('link', 'string', [
            'default' => null,
            'limit' => 1024,
            'null' => false
        ]);
        $table->addColumn('icon', 'string', [
            'default' => null,
            'limit' => 32,
            'null' => false
        ]);
        $table->addColumn('seen', 'integer', [
            'default' => 0
        ]);
        $table->addColumn('completed', 'integer', [
            'default' => 0
        ]);
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();
    }
}
