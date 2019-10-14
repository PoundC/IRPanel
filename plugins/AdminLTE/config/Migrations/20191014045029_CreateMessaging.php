<?php
use Migrations\AbstractMigration;

class CreateMessaging extends AbstractMigration
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
        $table = $this->table('messaging');
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 36,
            'null' => false,
        ]);
        $table->addColumn('to_user_id', 'string', [
            'default' => null,
            'limit' => 36,
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
        $table->addColumn('messaging_id', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('read', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('recipient_read', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('replied', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('priority', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('user_deleted', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('recipient_deleted', 'integer', [
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

    }
}
