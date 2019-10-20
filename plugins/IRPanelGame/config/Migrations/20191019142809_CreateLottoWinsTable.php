<?php
use Migrations\AbstractMigration;

class CreateLottoWinsTable extends AbstractMigration
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
        $table = $this->table('i_r_c_game_lotto_wins');
        $table->addColumn('i_r_c_game_player_id', 'integer');
        $table->addColumn('i_r_c_game_lotto_id', 'integer');
        $table->addColumn('number_count', 'integer');
        $table->addColumn('rewarded_cash', 'integer');
        $table->addColumn('created', 'datetime');
        $table->create();
    }
}
