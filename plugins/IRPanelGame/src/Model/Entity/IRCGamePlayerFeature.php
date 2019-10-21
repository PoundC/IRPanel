<?php
namespace IRPanelGame\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCGamePlayerFeature Entity
 *
 * @property int $id
 * @property int $i_r_c_game_player_id
 * @property int $i_r_c_game_feature_id
 * @property int $power_power
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \IRPanelGame\Model\Entity\IRCGamePlayer $i_r_c_game_player
 * @property \IRPanelGame\Model\Entity\IRCGameFeature $i_r_c_game_feature
 */
class IRCGamePlayerFeature extends Entity
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
        'i_r_c_game_player_id' => true,
        'i_r_c_game_feature_id' => true,
        'power_power' => true,
        'created' => true,
        'modified' => true,
        'i_r_c_game_player' => true,
        'i_r_c_game_feature' => true
    ];
}
