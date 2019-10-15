<?php
use Migrations\AbstractMigration;

class AddTopicToIRCQuotes extends AbstractMigration
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
        $table = $this->table('i_r_c_quotes');
        $table->addColumn('topic', 'text');
        $table->update();
    }
}
