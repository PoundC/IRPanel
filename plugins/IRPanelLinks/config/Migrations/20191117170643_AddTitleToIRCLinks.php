<?php
use Migrations\AbstractMigration;

class AddTitleToIRCLinks extends AbstractMigration
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
        $table = $this->table('i_r_c_links');
        $table->addColumn('title', 'text');
        $table->update();
    }
}
