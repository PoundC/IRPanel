<?php
use Migrations\AbstractMigration;

class FixSearchable2 extends AbstractMigration
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
        $table->changeColumn('searchable', 'text',[
            'limit' => \Phinx\Db\Adapter\MysqlAdapter::TEXT_MEDIUM
        ]);
        $table->save();
    }
}
