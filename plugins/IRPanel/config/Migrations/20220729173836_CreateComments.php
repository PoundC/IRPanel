<?php
use Migrations\AbstractMigration;

class CreateComments extends AbstractMigration
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
        $table = $this->table('comments');
        $table->addColumn('i_r_c_users_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('table_name', 'string',[
            'default' => null,
            'limit' => 64,
            'null' => false
        ]);
        $table->addColumn('table_row_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('comment_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('comment', 'text', [
            'default' => null,
            'null' => false
        ]);
        $table->create();
    }
}
