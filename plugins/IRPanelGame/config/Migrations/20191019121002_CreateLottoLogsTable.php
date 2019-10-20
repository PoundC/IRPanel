<?php
use Migrations\AbstractMigration;

class CreateLottoLogsTable extends AbstractMigration
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
        $table = $this->table('i_r_c_game_lottos');
        $table->addColumn('lotto_one', 'integer');
        $table->addColumn('lotto_two', 'integer');
        $table->addColumn('lotto_three', 'integer');
        $table->addColumn('lotto_four', 'integer');
        $table->addColumn('lotto_five', 'integer');
        $table->addColumn('lotto_six', 'integer');
        $table->addColumn('created', 'datetime');
        $table->create();
    }
}
