<?php
namespace IRPanelGame\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCGamePlayer Entity
 *
 * @property int $id
 * @property int $i_r_c_user_registration_id
 * @property int $cash
 * @property int $points
 * @property int $score
 * @property int $power
 * @property string $war_cry
 * @property string $o_noise
 * @property string $hack_words
 * @property string $steal_slogan
 * @property string $smack_words
 * @property string $greeting
 * @property int $lotto_one
 * @property int $lotto_two
 * @property int $lotto_three
 * @property int $lotto_four
 * @property int $lotto_five
 * @property int $lotto_six
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \IRPanelGame\Model\Entity\IRCUserRegistration $i_r_c_user_registration
 * @property \IRPanelGame\Model\Entity\IRCGameBet[] $i_r_c_game_bets
 * @property \IRPanelGame\Model\Entity\IRCGameFeatureText[] $i_r_c_game_feature_texts
 * @property \IRPanelGame\Model\Entity\IRCGameLog[] $i_r_c_game_logs
 * @property \IRPanelGame\Model\Entity\IRCGameLottoWin[] $i_r_c_game_lotto_wins
 * @property \IRPanelGame\Model\Entity\IRCGamePlayerFeature[] $i_r_c_game_player_features
 */
class IRCGamePlayer extends Entity
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
        'i_r_c_user_registration_id' => true,
        'cash' => true,
        'points' => true,
        'score' => true,
        'power' => true,
        'war_cry' => true,
        'o_noise' => true,
        'hack_words' => true,
        'steal_slogan' => true,
        'smack_words' => true,
        'greeting' => true,
        'lotto_one' => true,
        'lotto_two' => true,
        'lotto_three' => true,
        'lotto_four' => true,
        'lotto_five' => true,
        'lotto_six' => true,
        'created' => true,
        'modified' => true,
        'i_r_c_user_registration' => true,
        'i_r_c_game_bets' => true,
        'i_r_c_game_feature_texts' => true,
        'i_r_c_game_logs' => true,
        'i_r_c_game_lotto_wins' => true,
        'i_r_c_game_player_features' => true
    ];
}
