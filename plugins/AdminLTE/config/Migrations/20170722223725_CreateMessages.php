<?php
use Migrations\AbstractMigration;

class CreateMessages extends AbstractMigration
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
        $table = $this->table('messages');
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('subject', 'string', [
            'default' => null,
            'limit' => 2048,
            'null' => false,
        ]);
        $table->addColumn('message', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('message_id', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('read', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('replied', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('priority', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('topic', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('closed', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();


        $table = $this->table('recipients');
        $table->addColumn('message_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('to', 'integer', [
            'default' => 1,
            'null' => false,
        ]);
        $table->addColumn('cc', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('bcc', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->create();
    }
}
