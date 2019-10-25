<?php
use Migrations\AbstractMigration;

class AlterTasksAddColorButton extends AbstractMigration
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
        $table = $this->table('admin_l_t_e_tasks');
        $table->addColumn('color', 'enum', [
            'values' => [
                'Success',
                'Info',
                'Warning',
                'Danger'
            ]
        ]);
        $table->addColumn('button_text', 'string', [
            'default' => null,
            'limit' => 48,
            'null' => false
        ]);
        $table->update();
    }
}
