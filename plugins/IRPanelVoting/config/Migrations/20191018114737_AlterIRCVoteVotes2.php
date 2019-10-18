<?php
use Migrations\AbstractMigration;

class AlterIRCVoteVotes2 extends AbstractMigration
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
        $tableDetails->renameColumn('i_r_c_vote_proposals', 'i_r_c_vote_proposal_id');
        $tableDetails->update();
    }
}
