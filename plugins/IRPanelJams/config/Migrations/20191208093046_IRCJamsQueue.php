<?php
use Migrations\AbstractMigration;

class IRCJamsQueue extends AbstractMigration
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
        $table = $this->table('i_r_c_jams_queue');
        $table->addColumn('i_r_c_jam_id', 'integer');
        $table->addColumn('i_r_c_users_id', 'integer');
        $table->addColumn('played', 'enum', [
            'values' => [
                'yes',
                'no'
            ]
        ]);
        $table->addColumn('playedts', 'datetime');
        $table->addColumn('created', 'datetime');
        $table->create();
    }
}

