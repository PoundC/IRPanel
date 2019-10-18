<?php
use Migrations\AbstractMigration;

class CreateIRCVotes extends AbstractMigration
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
        $table = $this->table('i_r_c_vote_proposals');
        $table->addColumn('name', 'string', [
            'default' => '',
            'limit' => 128,
            'null' => false
        ]);
        $table->addColumn('description', 'text');
        $table->addColumn('yay', 'integer');
        $table->addColumn('nay', 'integer');
        $table->addColumn('abstain', 'integer');
        $table->addColumn('completed', 'integer',[
            'default' => 0
        ]);
        $table->addColumn('i_r_c_user_registration_id', 'integer');
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();

        $tableDetails = $this->table('i_r_c_vote_votes');
        $tableDetails->addColumn('i_r_c_vote_id', 'integer');
        $tableDetails->addColumn('i_r_c_user_registration_id', 'integer');
        $tableDetails->addColumn('vote', 'enum', [
            'values' => ['yay', 'nay', 'abstain']
        ]);
        $tableDetails->addColumn('created', 'datetime');
        $tableDetails->create();
    }
}
