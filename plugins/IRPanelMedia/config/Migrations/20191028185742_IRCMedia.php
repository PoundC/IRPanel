<?php
use Migrations\AbstractMigration;

class IRCMedia extends AbstractMigration
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
        $table = $this->table('i_r_c_media');
        $table->addColumn('i_r_c_users_id', 'integer');
        $table->addColumn('link', 'text');
        $table->addColumn('searchable', 'text');
        $table->addColumn('description', 'text');
        $table->addColumn('title', 'text');
        $table->addColumn('media_type', 'string', [
            'limit' => '32'
        ]);
        $table->addColumn('created', 'datetime');
        $table->create();

        $table->addIndex('searchable', ['type' => 'fulltext']);
        $table->addIndex('description', ['type' => 'fulltext']);
        $table->addIndex('title', ['type' => 'fulltext']);
        $table->addIndex('media_type');
        $table->save();
    }
}
