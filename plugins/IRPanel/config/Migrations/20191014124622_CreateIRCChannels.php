<?php
use Migrations\AbstractMigration;

class CreateIRCChannels extends AbstractMigration
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
        $table = $this->table('i_r_c_channels');
        $table->addColumn('i_r_c_network_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('pound_name', 'string',[
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('keys', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('knock_nick', 'string', [
            'default' => null,
            'limit' => 32,
            'null' => false
        ]);
        $table->addColumn('topic', 'string', [
            'default' => null,
            'limit' => 1024,
            'null' => false
        ]);
        $table->create();
    }
}
