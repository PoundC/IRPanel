<?php
use Migrations\AbstractMigration;

class CreatePlayerFeaturesTable extends AbstractMigration
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
        $table = $this->table('i_r_c_game_player_features');
        $table->addColumn('i_r_c_game_player_id', 'integer');
        $table->addColumn('i_r_c_game_feature_id', 'integer');
        $table->addColumn('power_power', 'integer');
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();
    }
}
