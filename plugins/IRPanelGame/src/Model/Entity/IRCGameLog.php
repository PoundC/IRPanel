<?php
namespace IRPanelGame\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCGameLog Entity
 *
 * @property int $id
 * @property int $i_r_c_game_player_id
 * @property string $feature_type
 * @property string $feature_name
 * @property int $i_r_c_feature_text_id
 * @property int $power_cash
 * @property int $power_points
 * @property int $power_score
 * @property int $power_power
 * @property int $power_multiplier
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \IRPanelGame\Model\Entity\IRCGamePlayer $i_r_c_game_player
 * @property \IRPanelGame\Model\Entity\IRCFeatureText $i_r_c_feature_text
 * @property \IRPanelGame\Model\Entity\IRCGameBet[] $i_r_c_game_bets
 */
class IRCGameLog extends Entity
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
        'feature_type' => true,
        'feature_name' => true,
        'i_r_c_feature_text_id' => true,
        'power_cash' => true,
        'power_points' => true,
        'power_score' => true,
        'power_power' => true,
        'power_multiplier' => true,
        'created' => true,
        'i_r_c_game_player' => true,
        'i_r_c_feature_text' => true,
        'i_r_c_game_bets' => true
    ];
}
