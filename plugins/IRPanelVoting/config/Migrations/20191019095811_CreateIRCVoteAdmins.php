<?php
use Migrations\AbstractMigration;

class CreateIRCVoteAdmins extends AbstractMigration
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
        $table = $this->table('i_r_c_vote_admins');
        $table->addColumn('i_r_c_user_registration_id', 'integer');
        $table->create();
    }
}
