<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:23 AM
 */

namespace IRPanelVoting\Controller;

use IRPanelVoting\Controller\AppController;

use Cake\Core\Configure;
use AdminLTE\Utility\Users;

class VotesController extends AppController
{
    public $paginate = [
        'limit' => 15,
        'order' => [
            'IRCVoteProposals.id' => 'desc'
        ]
    ];

    public function proposals()
    {
        $this->loadModel('IRPanelVoting.IRCVoteProposals');

        $votes = $this->paginate($this->IRCVoteProposals->find('all', ['contain' => ['IRCUserRegistrations']])->where([
            'vetting' => 0,
            'OR' => [
                ['completed' => 0],
                ['completed' => 1]
            ]
        ]));

        $this->set('i_r_c_vote_proposals', $votes);
    }

    public function view($id = null)
    {
        if($id == null) {

            return $this->redirect('/voting/proposals');
        }

        $this->loadModel('IRPanelVoting.IRCVoteProposals');
        $this->loadModel('IRPanel.IRCUserRegistrations');
        $this->loadModel('IRPanelVoting.IRCVoteVotes');

        $user = $this->IRCUserRegistrations->find('all')->where(['registered_nickname' => $this->Auth->user('username')])->first();

        $proposal = $this->IRCVoteProposals->find('all', ['contain' => ['IRCUserRegistrations', 'IRCVoteVotes', 'IRCVoteVotes.IRCUserRegistrations']])->where(['IRCVoteProposals.id' => $id])->first();

        $userVoted = $this->IRCVoteVotes->find('all')->where(['i_r_c_user_registration_id' => $user->id, 'i_r_c_vote_proposal_id' => $proposal->id])->first();

        if(!$userVoted) {

            $this->set('userCanVote', true);
        }
        else {

            $this->set('userCanVote', false);
        }

        $this->set('proposal', $proposal);
    }

    public function search()
    {
        $this->loadModel('IRPanelVoting.IRCVoteProposals');

        if($this->request->getMethod() == 'POST') {

            $search = $this->request->getData('search');

            $searchResults = $this->paginate($this->IRCVoteProposals->find('all', ['contain' => ['IRCUserRegistrations']])->where([
                    'OR' => [
                        ['name LIKE' => '%' . $search . '%'],
                        ['description LIKE' => '%' . $search . '%'],
                        ['registered_nickname LIKE' => '%' . $search . '%']
                    ]
                ])
            );

            $this->set('results', $searchResults);
        }
    }

    public function vote($id)
    {
        $this->loadModel('IRPanelVoting.IRCVoteProposals');
        $this->loadModel('IRPanelVoting.IRCVoteVotes');
        $this->loadModel('IRPanel.IRCUserRegistrations');


        if($this->request->getMethod() == 'POST') {

            $user = $this->IRCUserRegistrations->find('all')->where(['registered_nickname' => $this->Auth->user('username')])->first();
            $proposal = $this->IRCVoteProposals->find('all')->where(['IRCVoteProposals.id' => $id])->first();
            $userVoted = $this->IRCVoteVotes->find('all')->where(['i_r_c_user_registration_id' => $user->id, 'i_r_c_vote_proposal_id' => $proposal->id])->first();

            if(!$userVoted) {
                $button = $this->request->getData('sbmt');

                switch ($button) {
                    case 'yay':
                        $proposal->set('yay', $proposal->get('yay') + 1);
                        break;
                    case 'nay':
                        $proposal->set('nay', $proposal->get('nay') + 1);
                        break;
                    case 'abstain':
                        $proposal->set('abstain', $proposal->get('abstain') + 1);
                        break;
                }

                $this->IRCVoteProposals->save($proposal);

                $voteEntity = $this->IRCVoteVotes->newEntity([
                    'i_r_c_vote_proposal_id' => $proposal->id,
                    'i_r_c_user_registration_id' => $user->id,
                    'vote' => $button,
                    'message' => '',
                    'created' => new \DateTime('now')
                ]);
                $this->IRCVoteVotes->save($voteEntity);

                $this->Flash->success('Your vote of ' . $button . ' has been saved.');
            }
            else {

                $this->Flash->error('You have already voted on this vote.');
            }
        }

        return $this->redirect('/voting/votes/view/' . $proposal->id);
    }
}
