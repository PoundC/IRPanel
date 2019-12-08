<?php
namespace IRPanelJams\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCJamsQueue Entity
 *
 * @property int $id
 * @property int $i_r_c_jam_id
 * @property int $i_r_c_user_id
 * @property string $played
 * @property \Cake\I18n\FrozenTime $playedts
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \IRPanelJams\Model\Entity\IRCJam $i_r_c_jam
 * @property \IRPanelJams\Model\Entity\IRCUser $i_r_c_user
 */
class IRCJamsQueue extends Entity
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
        'i_r_c_jam_id' => true,
        'i_r_c_users_id' => true,
        'played' => true,
        'playedts' => true,
        'created' => true,
        'i_r_c_jam' => true,
        'i_r_c_user' => true
    ];
}
