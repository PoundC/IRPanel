<?php
namespace IRPanelGame\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCGameFeature Entity
 *
 * @property int $id
 * @property string $feature_type
 * @property string $feature_name
 * @property string $feature_use
 * @property string $feature_help
 * @property int $power_cash
 * @property int $power_points
 * @property int $power_score
 * @property int $power_power
 * @property int $power_multiplier_min
 * @property int $power_multiplier_max
 * @property int $power_multiplier_weight
 * @property int $daily_use_limit
 * @property int $buy_cost_weight
 * @property int $order_index
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \IRPanelGame\Model\Entity\IRCGameFeatureText[] $i_r_c_game_feature_texts
 * @property \IRPanelGame\Model\Entity\IRCGamePlayerFeature[] $i_r_c_game_player_features
 */
class IRCGameFeature extends Entity
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
        'feature_type' => true,
        'feature_name' => true,
        'feature_use' => true,
        'feature_help' => true,
        'power_cash' => true,
        'power_points' => true,
        'power_score' => true,
        'power_power' => true,
        'power_multiplier_min' => true,
        'power_multiplier_max' => true,
        'power_multiplier_weight' => true,
        'daily_use_limit' => true,
        'buy_cost_weight' => true,
        'order_index' => true,
        'created' => true,
        'modified' => true,
        'i_r_c_game_feature_texts' => true,
        'i_r_c_game_player_features' => true
    ];
}
