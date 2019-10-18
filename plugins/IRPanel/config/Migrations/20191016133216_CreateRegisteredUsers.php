<?php
use Migrations\AbstractMigration;

class CreateRegisteredUsers extends AbstractMigration
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
        $table = $this->table('i_r_c_user_registrations');
        $table->addColumn('i_r_c_network_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('registered_nickname', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->create();
    }
}
