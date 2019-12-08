<?php
namespace IRPanelJams\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCJam Entity
 *
 * @property int $id
 * @property int $i_r_c_user_id
 * @property string $link
 * @property string $searchable
 * @property string $description
 * @property string $title
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \IRPanelJams\Model\Entity\IRCUser $i_r_c_user
 */
class IRCJam extends Entity
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
        'link' => true,
        'searchable' => true,
        'description' => true,
        'title' => true,
        'created' => true,
        'i_r_c_user' => true
    ];
}
