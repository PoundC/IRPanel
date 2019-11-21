<?php
use Migrations\AbstractMigration;

class IRCLinks extends AbstractMigration
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
        $table->addColumn('i_r_c_users_id', 'integer');
        $table->addColumn('link', 'string', [
            'default' => '',
            'limit' => 3000,
            'null' => false
        ]);
        $table->addColumn('searchable', 'text');
        $table->addColumn('created', 'datetime');
        $table->create();

        $table->addIndex('searchable', ['type' => 'fulltext']);
        $table->addIndex('link');
        $table->save();
    }
}
