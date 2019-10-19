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
            'command.listprops' => 'handleList',
            'command.delprop' => 'handleDelete',
            'command.vote' => 'handleVote',
            'command.propose' => 'handlePropose',
            'command.complete' => 'handleComplete',
            'command.votestats' => 'handleStats',
            'command.change' => 'handleChange',
            'command.change.help' => 'handleChangeHelp',
            'command.votestats.help' => 'handleStatsHelp',
            'command.list.help' => 'handleListHelp',
            'command.delprop.help' => 'handleDeleteHelp',
            'command.vote.help' => 'handleVoteHelp',
            'command.propose.help' => 'handleProposalHelp',
            'command.complete.help' => 'handleCompleteHelp'
        ];
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
        $proposal = $proposalsTable->find('all')->where(['name' => $target])->first();

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

        $queue->ircNotice($source, 'Proposal Created[' . $proposal->id . ']: ' . $target);
    }

    public function handleList(CommandEvent $event, EventQueueInterface $queue) {

        $proposalsTable = TableRegistry::get('i_r_c_vote_proposals');
        $proposals = $proposalsTable->find('all')->where(['completed' => 0])->all();

        $queue->ircNotice($event->getSource(), 'Current Uncompleted Proposals List');

        foreach($proposals as $proposal) {

            $queue->ircNotice($event->getSource(), 'Prop (' . $proposal->id . ') ' . $proposal->get('name') . ' = ' . $proposal->get('description'));
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
                ->Where(['id' => $proposalName])
                ->first();
        }
        else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName])
                ->first();
        }

        if(!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        $proposal->set($proposalVote, $proposal->get($proposalVote) + 1);
        $proposalsTable->save($proposal);

        $votesTable = TableRegistry::get('i_r_c_vote_votes');
        $vote = $votesTable->find('all')->where([
            'i_r_c_vote_proposal_id' => $proposal->id,
            'i_r_c_user_registration_id' => $user->getRegistrationUserId()
        ])->first();

        if(!$vote) {

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

            return $queue->ircNotice($event->getSource(), 'You have already voted on this proposal.');
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
                ->Where(['id' => $proposalName])
                ->first();
        }
        else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName])
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
                ->Where(['id' => $proposalName])
                ->first();
        } else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName])
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
                ->Where(['id' => $proposalName])
                ->first();
        } else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName])
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
                ->Where(['id' => $proposalName])
                ->first();
        }
        else {

            $proposal = $proposalsTable->find('all')
                ->where(['name' => $proposalName])
                ->first();
        }

        if(!$proposal) {

            return $queue->ircNotice($event->getSource(), 'No proposal found.');
        }

        if($proposal->get('i_r_c_user_registration_id') == $user->getRegistrationUserId()) {

            $proposal->set('completed', 2);

            $proposalsTable->save($proposal);

            $queue->ircNotice($event->getSource(), 'Proposal has been deleted.');
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
}
