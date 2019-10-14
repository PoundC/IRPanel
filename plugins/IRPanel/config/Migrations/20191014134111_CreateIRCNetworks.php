<?php
use Migrations\AbstractMigration;

class CreateIRCNetworks extends AbstractMigration
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
        $table = $this->table('i_r_c_networks');
        $table->addColumn('network_name', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('username', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('realname', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('nickname', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('altnick', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('nickserv_password', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->create();
    }
}
