<?php
use Migrations\AbstractMigration;

class CreatePlayersTable extends AbstractMigration
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
        $table = $this->table('i_r_c_game_players');
        $table->addColumn('i_r_c_user_registration_id', 'integer');
        $table->addColumn('cash', 'integer');
        $table->addColumn('points', 'integer');
        $table->addColumn('score', 'integer');
        $table->addColumn('power', 'integer');
        $table->addColumn('war_cry', 'text');
        $table->addColumn('o_noise', 'text');
        $table->addColumn('hack_words', 'text');
        $table->addColumn('steal_slogan', 'text');
        $table->addColumn('smack_words', 'text');
        $table->addColumn('greeting', 'text');
        $table->addColumn('lotto_one', 'integer');
        $table->addColumn('lotto_two', 'integer');
        $table->addColumn('lotto_three', 'integer');
        $table->addColumn('lotto_four', 'integer');
        $table->addColumn('lotto_five', 'integer');
        $table->addColumn('lotto_six', 'integer');
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();
    }
}
