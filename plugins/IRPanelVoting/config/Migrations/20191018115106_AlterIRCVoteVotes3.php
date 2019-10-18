<?php
use Migrations\AbstractMigration;

class AlterIRCVoteVotes3 extends AbstractMigration
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
        $tableDetails->addColumn('message', 'text');
        $tableDetails->update();
    }
}
