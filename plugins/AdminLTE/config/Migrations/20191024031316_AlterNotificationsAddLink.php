<?php
use Migrations\AbstractMigration;

class AlterNotificationsAddLink extends AbstractMigration
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
        $table = $this->table('notifications');
        $table->addColumn('link', 'string', [
            'default' => '',
            'limit' => 1024
        ]);
        $table->update();
    }
}
