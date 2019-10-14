<?php
use Migrations\AbstractMigration;

class CreateIRCServers extends AbstractMigration
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
        $table = $this->table('i_r_c_servers');
        $table->addColumn('i_r_c_network_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('hostname', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('port', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('server_password', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('oper_password', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('ssl', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->create();
    }
}
