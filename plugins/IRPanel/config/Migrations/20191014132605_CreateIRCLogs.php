<?php
use Migrations\AbstractMigration;

class CreateIRCLogs extends AbstractMigration
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
        $table = $this->table('i_r_c_logs');
        $table->addColumn('i_r_c_network_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('i_r_c_channel_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('i_r_c_user_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('msg_type', 'string', [
            'default' => null,
            'limit' => 32,
            'null' => false
        ]);
        $table->addColumn('message', 'text', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('context', 'text', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false
        ]);
        $table->create();
    }
}
