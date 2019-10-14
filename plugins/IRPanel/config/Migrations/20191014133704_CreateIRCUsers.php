<?php
use Migrations\AbstractMigration;

class CreateIRCUsers extends AbstractMigration
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
        $table = $this->table('i_r_c_users');
        $table->addColumn('i_r_c_network_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('i_r_c_server_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('is_oper', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('username', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('hostname', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('nickname', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('realname', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->create();
    }
}
