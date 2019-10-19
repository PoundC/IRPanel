<?php
use Migrations\AbstractMigration;

class AlterIRCVotes extends AbstractMigration
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
        $table->addColumn('vetting', 'integer', [
            'default' => 0
        ]);
        $table->update();
    }
}
