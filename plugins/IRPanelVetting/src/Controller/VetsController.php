<?php

namespace IRPanelVetting\Controller;

use IRPanelVetting\Controller\AppController;

class VetsController extends AppController {

    public $paginate = [
        'limit' => 15,
        'order' => [
            'IRCVoteProposals.id' => 'desc'
        ]
    ];

    public function nominations()
    {
        $this->loadModel('IRPanelVoting.IRCVoteProposals');

        $votes = $this->paginate($this->IRCVoteProposals->find('all', ['contain' => ['IRCUserRegistrations']])->where([
            'vetting' => 1,
            'OR' => [
                ['completed' => 0],
                ['completed' => 1]
            ]
        ]));

        $this->set('i_r_c_vote_proposals', $votes);
    }
}
