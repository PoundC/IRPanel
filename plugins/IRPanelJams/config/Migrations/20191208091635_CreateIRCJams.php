<?php
use Migrations\AbstractMigration;

class CreateIRCJams extends AbstractMigration
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
        $table = $this->table('i_r_c_jams');
        $table->addColumn('i_r_c_users_id', 'integer');
        $table->addColumn('link', 'string', [
            'limit' => 3000,
            'null' => false
        ]);
        $table->addColumn('searchable', 'text');
        $table->addColumn('description', 'text');
        $table->addColumn('title', 'text');
        $table->addColumn('created', 'datetime');
        $table->create();

        $table->addIndex('searchable', ['type' => 'fulltext']);
        $table->addIndex('description', ['type' => 'fulltext']);
        $table->addIndex('title', ['type' => 'fulltext']);
        $table->save();
    }
}
