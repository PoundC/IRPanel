<?php
use Migrations\AbstractMigration;

class CreateBetsTable extends AbstractMigration
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
        $table = $this->table('i_r_c_game_bets');
        $table->addColumn('i_r_c_game_player_id', 'integer');
        $table->addColumn('i_r_c_game_challenger_id', 'integer');
        $table->addColumn('bet_cash_size', 'integer');
        $table->addColumn('i_r_c_game_log_id', 'integer');
        $table->addColumn('winner_is', 'integer');
        $table->addColumn('created', 'datetime');
        $table->create();
    }
}
