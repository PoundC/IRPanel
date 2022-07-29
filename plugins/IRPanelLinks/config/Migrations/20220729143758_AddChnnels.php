<?php
use Migrations\AbstractMigration;

class MediaAddChnnels extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('i_r_c_links');
        $table->addColumn('i_r_c_channel_id', 'integer');
        $table->update();
    }
}
