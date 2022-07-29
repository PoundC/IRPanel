<?php
use Migrations\AbstractMigration;

class AddAvatarsToUsers extends AbstractMigration
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
        $table = $this->table('admin_l_t_e_users');
        $table->addColumn('avatar', 'string', [
            'limit' => '512'
        ]);
        $table->update();
    }
}
