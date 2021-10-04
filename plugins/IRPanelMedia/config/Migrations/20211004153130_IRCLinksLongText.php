<?php
use Migrations\AbstractMigration;

class IRCLinksLongText extends AbstractMigration
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
        $table = $this->table('i_r_c_media');
        $table->changeColumn('searchable', 'longtext');
        $table->save();
    }
}
