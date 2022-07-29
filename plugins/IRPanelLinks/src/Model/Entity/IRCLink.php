<?php
namespace IRPanelLinks\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCLink Entity
 *
 * @property int $id
 * @property int $i_r_c_users_id
 * @property string $link
 * @property string $searchable
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \IRPanelLinks\Model\Entity\IRCUser $i_r_c_user
 */
class IRCLink extends Entity
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
        'i_r_c_users_id' => true,
        'i_r_c_channel_id' => true,
        'link' => true,
        'searchable' => true,
        'created' => true,
        'i_r_c_user' => true,
        'description' => true,
        'title' => true
    ];
}
