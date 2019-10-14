<?php
use Migrations\AbstractMigration;

class CreateIRCRantLines extends AbstractMigration
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
        $table = $this->table('i_r_c_rant_lines');
        $table->addColumn('i_r_c_rant_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('line_of_text', 'text', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false
        ]);
        $table->create();
    }
}
