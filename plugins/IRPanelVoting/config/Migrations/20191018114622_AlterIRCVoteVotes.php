<?php
use Migrations\AbstractMigration;

class AlterIRCVoteVotes extends AbstractMigration
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
        $tableDetails = $this->table('i_r_c_vote_votes');
        $tableDetails->renameColumn('i_r_c_vote_id', 'i_r_c_vote_proposals');
        $tableDetails->update();
    }
}
