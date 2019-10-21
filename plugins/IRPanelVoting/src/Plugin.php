<?php

namespace IRPanelVoting;

use IRPanel\Core\AbstractPlugin;
use Cake\ORM\TableRegistry;
use Phergie\Irc\Bot\React\EventQueueInterface;
use Phergie\Irc\Plugin\React\Command\CommandEvent;
use IRPanel\Utility\Database;

/**
 * Plugin for IRPanelQuotes
 */
class Plugin extends AbstractPlugin
{
    public function getSubscribedEvents()
    {
        if (!$this->connection) {
            return [];
        }
        return [
            'command.voteadmin' => 'handleAdmin',
            'command.listprops' => 'handleList',
            'command.listprop' => 'handleListVotes',
            'command.delprop' => 'handleDelete',
            'command.vote' => 'handleVote',
            'command.propose' => 'handlePropose',
            'command.complete' => 'handleComplete',
            'command.votestats' => 'handleStats',
            'command.change' => 'handleChange',
            'command.voteadmin.help' => 'handleAdminHelp',
            'command.change.help' => 'handleChangeHelp',
            'command.votestats.help' => 'handleStatsHelp',
            'command.list.help' => 'handleListHelp',
            'command.delprop.help' => 'handleDeleteHelp',
            'command.vote.help' => 'handleVoteHelp',
            'command.propose.help' => 'handleProposalHelp',
            'command.complete.help' => 'handleCompleteHelp'
        ];
    }

    public function handleAdmin(CommandEvent $event, EventQueueInterface $queue) {

        $adminTable = TableRegistry::get('i_r_c_vote_admins');

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);
        $source = $event->getSource();
        $params = $event->getCustomParams();

        if(count($params) > 1 || count($params) == 0) {

            return $queue->ircNotice($source, 'Incorrect amount of parameters, see !voteadmin.help for example.');
        }

        $target = $params[0];
        array_shift($params);

        if($user->isIdentified() != 1) {

            return $queue->ircNotice($source, 'I do not recognize you, please login and then !ident');
        }

        $adminUser = $adminTable->find('all')->where(['i_r_c_user_registration_id' => $user->getRegistrationUserID()])->first();

        if(!$adminUser) {

            return $queue->ircNotice($source, 'Could not find your admin account, please /msg IRBot login ' . $nick . ' <your_password> OR !ident if already logged into UserServ');
        }

        $nextAdminUser = $this->client->readDataStorage($networkId . '.Users.' . $target);

        if(!$nextAdminUser) {

            return $queue->ircNotice($source, 'Could not find target user, are they in this channel?');
        }

        if($nextAdminUser->isIdentified() != 1) {

            return $queue->ircNotice($source, 'I do not recognize ' . $target . ', are they registered? Please have them login and then !ident');
        }

        $adminEntity = $adminTable->find('all')->where(['i_r_c_user_registration_id' => $nextAdminUser->getRegistrationUserID()])->first();

        if($adminEntity) {

            return $queue->ircNotice($source, $target . ' already an admin user.');
        }

        $adminEntity = $adminTable->newEntity([
            'i_r_c_user_registration_id' => $nextAdminUser->getRegistrationUserId()
        ]);
        $adminTable->save($adminEntity);

        $queue->ircNotice($source, $target . ' added as VoteAdmin.');
    }

    public function handlePropose(CommandEvent $event, EventQueueInterface $queue) {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);
        $source = $event->getSource();

        if($user->isIdentified() == false) {

            return $queue->ircNotice($source, 'I do not recognize you, please login to UserServ and then !ident');
        }

        $params = $event->getCustomParams();
        list($target, $message) = explode('=', implode(' ', $params));
        $target = trim($target);
        $message = trim($message);

        $targetFirst = substr($target, 0, 1);

        if(is_numeric($targetFirst)) {

            return $queue->ircNotice($source, 'Proposal names can not start with an integer.');
        }

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        $proposal = $proposalsTable->find('all')->where(['name' => $target, 'completed' => 0])->first();

        if($proposal) {

            $user2 = Database::getRegistrationUserById($proposal->get('i_r_c_user_registration_id'));

            return $queue->ircNotice($source, 'Proposal already exists with that name, created on ' . $proposal->created->format('Y-m-d') . ' by ' . $user2->get('registered_nickname') . ' please try again.');
        }

        $proposal = $proposalsTable->newEntity([
            'name' => $target,
            'description' => $message,
            'yay' => 0,
            'nay' => 0,
            'abstain' => 0,
            'completed' => 0,
            'i_r_c_user_registration_id' => $user->getRegistrationUserID(),
            'created' => new \DateTime('now'),
            'modified' => new \DateTime('now')
        ]);

        $proposalsTable->save($proposal);

        $queue->ircNotice($source, 'Proposal(' . $proposal->id . ') Created: ' . $target);
    }

    public function handleList(CommandEvent $event, EventQueueInterface $queue) {

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        $proposals = $proposalsTable->find('all')->where(['completed' => 0])->all();

        $queue->ircNotice($event->getSource(), 'Current Votes In Progress');

        foreach($proposals as $proposal) {

            $user2 = Database::getRegistrationUserById($proposal->get('i_r_c_user_registration_id'));

            if($proposal->get('vetting') == 0) {

                $queue->ircNotice($event->getSource(), 'Prop(' . $proposal->id . ') ' . $proposal->get('name') . ' = ' . $proposal->get('description') . ' [' . $user2->get('registered_nickname') . ':' . $proposal->get('yay') . '/' . $proposal->get('nay') . '/' . $proposal->get('abstain') . ']');
            }
            else {

                $queue->ircNotice($event->getSource(), 'Nominee(' . $proposal->id . ') ' . $proposal->get('name') . ' = ' . $proposal->get('description') . ' [' . $user2->get('registered_nickname') . ':' . $proposal->get('yay') . '/' . $proposal->get('nay') . '/' . $proposal->get('abstain') . ']');
            }
        }
    }

    public function handleListVotes(CommandEvent $event, EventQueueInterface $queue) {

        $params = $event->getCustomParams();

        if(count($params) == 0)
        {
            return $queue->ircNotice($event->getSource(), 'Type !listprop.help for example.');
        }

        $proposalName = $params[0];
        array_shift($params);

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        if(is_numeric($proposalName)) {

            $proposal = $proposalsTable->find('all')
                ->Where(['id' => $proposalName, 'completed' => 0])
                ->first();
        }
        else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName, 'completed' => 0])
                ->first();
        }

        if(!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        $votesTable = TableRegistry::get('i_r_c_vote_votes');
        $votes = $votesTable->find('all')->where(['i_r_c_vote_proposal_id' => $proposal->id])->all();

        $queue->ircNotice($event->getSource(), 'Listing votes for ' . $proposal->get('name') . '(' . $proposal->get('id') . ')');
        foreach($votes as $vote)
        {
            $user = Database::getRegistrationUserById($vote->get('i_r_c_user_registration_id'));
            $queue->ircNotice($event->getSource(), $user->get('registered_nickname') . ' voted ' . $vote->get('vote') . ' on ' . $vote->get('created')->format('Y-m-d'));
        }
    }

    public function handleVote(CommandEvent $event, EventQueueInterface $queue) {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if($user->isIdentified() == false) {

            return $queue->ircNotice($event->getSource(), 'I do not recognize you, please login to UserServ and then !ident');
        }

        $params = $event->getCustomParams();

        $proposalName = $params[0];
        array_shift($params);

        if(count($params) == 0) {

            return $queue->ircNotice($event->getSource(), 'Please vote using yay, nay, or abstain. Type !vote.help for example.');
        }

        $proposalVote = $params[0];
        array_shift($params);

        if($proposalVote != 'yay' && $proposalVote != 'nay' && $proposalVote != 'abstain') {

            return $queue->ircNotice($event->getSource(), 'Please vote using yay, nay, or abstain. Type !vote.help for example.');
        }

        $message = implode(' ', $params);

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        if(is_numeric($proposalName)) {

            $proposal = $proposalsTable->find('all')
                ->Where(['id' => $proposalName, 'completed' => 0])
                ->first();
        }
        else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName, 'completed' => 0])
                ->first();
        }

        if(!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        $votesTable = TableRegistry::get('i_r_c_vote_votes');
        $vote = $votesTable->find('all')->where([
            'i_r_c_vote_proposal_id' => $proposal->id,
            'i_r_c_user_registration_id' => $user->getRegistrationUserId()
        ])->first();

        if(!$vote) {

            $proposal->set($proposalVote, $proposal->get($proposalVote) + 1);
            $proposalsTable->save($proposal);

            $voteEntity = $votesTable->newEntity([
                'i_r_c_vote_proposal_id' => $proposal->id,
                'i_r_c_user_registration_id' => $user->getRegistrationUserId(),
                'vote' => $proposalVote,
                'message' => $message,
                'created' => new \DateTime('now')
            ]);

            $votesTable->save($voteEntity);

            return $queue->ircNotice($event->getSource(), 'Thank you for voting on ' . $proposal->get('name'));
        }
        else {

            $oldVote = $vote->get('vote');
            $proposal->set($vote->get('vote'), $proposal->get($vote->get('vote')) - 1);
            $proposal->set($proposalVote, $proposal->get($proposalVote) + 1);
            $proposalsTable->save($proposal);

            $vote->set('vote', $proposalVote);
            $vote->set('message', $message);
            $votesTable->save($vote);

            return $queue->ircNotice($event->getSource(), $nick . ': Changing from ' . $oldVote . ' to ' . $proposalVote);
        }
    }

    public function handleComplete(CommandEvent $event, EventQueueInterface $queue) {

        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if($user->isIdentified() == false) {

            return $queue->ircNotice($event->getSource(), 'I do not recognize you, please login to UserServ and then !ident');
        }

        $params = $event->getCustomParams();

        $proposalName = $params[0];
        array_shift($params);

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        if(is_numeric($proposalName)) {

            $proposal = $proposalsTable->find('all')
                ->Where(['id' => $proposalName, 'completed' => 0])
                ->first();
        }
        else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName, 'completed' => 0])
                ->first();
        }

        if(!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        if($proposal->get('i_r_c_user_registration_id') == $user->getRegistrationUserId()) {

            $proposal->set('completed', 1);

            $proposalsTable->save($proposal);

            $queue->ircNotice($event->getSource(), 'Proposal has been completed.');
        }
        else {

            $queue->ircNotice($event->getSource(), 'You do not have permission to delete that proposal.');
        }
    }

    public function handleChange(CommandEvent $event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if ($user->isIdentified() == false) {

            return $queue->ircNotice($event->getSource(), 'I do not recognize you, please login to UserServ and then !ident');
        }

        $params = $event->getCustomParams();

        $proposalName = $params[0];
        array_shift($params);

        if(count($params) == 0) {

            return $queue->ircNotice($event->getSource(), 'Please vote using yay, nay, or abstain. Type !change.help for example.');
        }

        $proposalVote = $params[0];
        array_shift($params);

        if($proposalVote != 'yay' && $proposalVote != 'nay' && $proposalVote != 'abstain') {

            return $queue->ircNotice($event->getSource(), 'Please vote using yay, nay, or abstain. Type !change.help for example.');
        }

        $message = implode(' ', $params);

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        if (is_numeric($proposalName)) {

            $proposal = $proposalsTable->find('all')
                ->Where(['id' => $proposalName, 'completed' => 0])
                ->first();
        } else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName, 'completed' => 0])
                ->first();
        }

        if (!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        $votesTable = TableRegistry::get('i_r_c_vote_votes');
        $vote = $votesTable->find('all')->where([
            'i_r_c_vote_proposal_id' => $proposal->id,
            'i_r_c_user_registration_id' => $user->getRegistrationUserId()
        ])->first();

        if(!$vote) {

            $queue->ircNotice($event->getSource(), 'You haven\'t voted on that proposal yet, no change necessary.');
        }

        $proposal->set($vote->get('vote'), $proposal->get($vote->get('vote')) - 1);
        $proposal->set($proposalVote, $proposal->get($proposalVote) + 1);
        $proposalsTable->save($proposal);

        $vote->set('vote', $proposalVote);
        $vote->set('message', $message);
        $votesTable->save($vote);

        $queue->ircNotice($event->getSource(), 'Your vote has been updated.');
    }

    public function handleStats(CommandEvent $event, EventQueueInterface $queue)
    {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if ($user->isIdentified() == false) {

            return $queue->ircNotice($event->getSource(), 'I do not recognize you, please login to UserServ and then !ident');
        }

        $params = $event->getCustomParams();

        $proposalName = $params[0];
        array_shift($params);

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        if (is_numeric($proposalName)) {

            $proposal = $proposalsTable->find('all')
                ->Where(['id' => $proposalName, 'completed' => 0])
                ->first();
        } else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName, 'completed' => 0])
                ->first();
        }

        if (!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        $queue->ircNotice($event->getSource(), $proposal->get('name') . ' stats: yay(' . $proposal->get('yay') . ') nay(' . $proposal->get('nay') . ') abstain(' . $proposal->get('abstain') . ')');
    }

    public function handleDelete(CommandEvent $event, EventQueueInterface $queue) {
        $networkId = Database::getNetworkId($event->getConnection()->getServerHostname());
        $nick = $event->getNick();
        $user = $this->client->readDataStorage($networkId . '.Users.' . $nick);

        if($user->isIdentified() == false) {

            return $queue->ircNotice($event->getSource(), 'I do not recognize you, please login to UserServ and then !ident');
        }

        $params = $event->getCustomParams();

        $proposalName = $params[0];
        array_shift($params);

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        if(is_numeric($proposalName)) {

            $proposal = $proposalsTable->find('all')
                ->Where(['id' => $proposalName, 'completed' => 0])
                ->first();
        }
        else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName, 'completed' => 0])
                ->first();
        }

        if(!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        $adminTable = TableRegistry::get('i_r_c_vote_admins');
        $admin = $adminTable->find('all')->where(['i_r_c_user_registration_id' => $user->getRegistrationUserId()])->first();

        if($proposal->get('i_r_c_user_registration_id') == $user->getRegistrationUserId() || $admin) {

            $proposal->set('completed', 2);

            $proposalsTable->save($proposal);

            $queue->ircNotice($event->getSource(), 'Proposal ' . $proposal->id . ' has been deleted.');
        }
        else {

            $queue->ircNotice($event->getSource(), 'You do not have permission to delete that proposal.');
        }
    }

    public function handleProposalHelp(CommandEvent $event, EventQueueInterface $queue) {

        return $queue->ircNotice($event->getSource(), '!propose name.of.proposal = Description of proposal!');
    }

    public function handleStatsHelp(CommandEvent $event, EventQueueInterface $queue) {

        return $queue->ircNotice($event->getSource(), '!votestats (name.of.proposal || numeric_id)');
    }

    public function handleDeleteHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), '!delprop (name.of.proposal || numeric_id)');
    }

    public function handleListHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), '!listprops');
    }

    public function handleVoteHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), '!vote (name.of.proposal || numeric_id) (yay || nay || abstain) [Short Reason Why]');
    }

    public function handleCompleteHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), '!complete (name.of.proposal || numeric_id)');
    }

    public function handleChangeHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), '!change (name.of.proposal || numeric_id) (yay || nay || abstain) [Short Reason Why]');
    }

    public function handleAdminHelp(CommandEvent $event, EventQueueInterface $queue) {

        $queue->ircNotice($event->getSource(), '!voteadmin registered_user_nickname');
    }
}
