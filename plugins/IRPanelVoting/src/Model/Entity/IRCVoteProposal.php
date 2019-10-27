<?php
namespace IRPanelVoting\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCVoteProposal Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $yay
 * @property int $nay
 * @property int $abstain
 * @property int $completed
 * @property int $i_r_c_user_registration_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $vetting
 *
 * @property \IRPanelVoting\Model\Entity\IRCUserRegistration $i_r_c_user_registration
 * @property \IRPanelVoting\Model\Entity\IRCVoteVote[] $i_r_c_vote_votes
 */
class IRCVoteProposal extends Entity
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
        'name' => true,
        'description' => true,
        'yay' => true,
        'nay' => true,
        'abstain' => true,
        'completed' => true,
        'i_r_c_user_registration_id' => true,
        'created' => true,
        'modified' => true,
        'vetting' => true,
        'i_r_c_user_registration' => true,
        'i_r_c_vote_votes' => true
    ];
}
