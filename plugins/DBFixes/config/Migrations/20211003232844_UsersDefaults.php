<?php
use Migrations\AbstractMigration;

class UsersDefaults extends AbstractMigration
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
        $table = $this->table('users');
        $table->changeColumn('created', 'datetime', [
            'default' => '1971-01-01 00:00:00'
        ]);
        $table->changeColumn('modified', 'datetime', [
            'default' => '1971-01-01 00:00:00'
        ]);
        $table->save();
    }
}
