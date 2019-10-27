<?php
namespace IRPanelVoting\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCVoteVote Entity
 *
 * @property int $id
 * @property int $i_r_c_vote_proposal_id
 * @property int $i_r_c_user_registration_id
 * @property string $vote
 * @property \Cake\I18n\FrozenTime $created
 * @property string $message
 *
 * @property \IRPanelVoting\Model\Entity\IRCVoteProposal $i_r_c_vote_proposal
 * @property \IRPanelVoting\Model\Entity\IRCUserRegistration $i_r_c_user_registration
 */
class IRCVoteVote extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'i_r_c_vote_proposal_id' => true,
        'i_r_c_user_registration_id' => true,
        'vote' => true,
        'created' => true,
        'message' => true,
        'i_r_c_vote_proposal' => true,
        'i_r_c_user_registration' => true
    ];
}
