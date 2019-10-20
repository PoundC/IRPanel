<?php
use Migrations\AbstractMigration;

class CreateFeaturesTable extends AbstractMigration
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
        $table = $this->table('i_r_c_game_features');
        // Jobs, Item, Animal, Person, Property, Object
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
        $table->addColumn('feature_use', 'text');
        $table->addColumn('feature_help', 'text');
        $table->addColumn('power_cash', 'integer');
        $table->addColumn('power_points', 'integer');
        $table->addColumn('power_score', 'integer');
        $table->addColumn('power_power', 'integer');
        $table->addColumn('power_multiplier_min', 'integer');
        $table->addColumn('power_multiplier_max', 'integer');
        $table->addColumn('power_multiplier_weight', 'integer');
        $table->addColumn('daily_use_limit', 'integer');
        $table->addColumn('buy_cost_weight', 'integer');
        $table->addColumn('order_index', 'integer');
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();
    }
}
