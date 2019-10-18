<?php
use Migrations\AbstractMigration;

class CreateIRCIdents extends AbstractMigration
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
        $table = $this->table('i_r_c_user_idents');
        $table->addColumn('i_r_c_user_registration_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('i_r_c_user_id', 'integer', [
            'default' => null,
            'null' => false
        ]);
        $table->addColumn('idented', 'datetime');
        $table->addColumn('ident_ended', 'datetime');
        $table->create();
    }
}
