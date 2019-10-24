<?php
use Migrations\AbstractMigration;

class AlterNotificationsAddColor extends AbstractMigration
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
        $table->addColumn('color', 'enum', [
            'values' => [
                'Success',
                'Info',
                'Warning',
                'Danger'
            ]
        ]);
        $table->update();
    }
}
