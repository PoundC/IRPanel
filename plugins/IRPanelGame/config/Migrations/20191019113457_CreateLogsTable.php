<?php
use Migrations\AbstractMigration;

class CreateLogsTable extends AbstractMigration
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
        $table = $this->table('i_r_c_game_logs');
        $table->addColumn('i_r_c_game_player_id', 'integer');
        $table->addColumn('feature_type', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('feature_name', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('i_r_c_feature_text_id', 'integer');
        $table->addColumn('power_cash', 'integer');
        $table->addColumn('power_points', 'integer');
        $table->addColumn('power_score', 'integer');
        $table->addColumn('power_power', 'integer');
        $table->addColumn('power_multiplier', 'integer');
        $table->addColumn('created', 'datetime');
        $table->create();
    }
}
