<?php
namespace AdminLTE\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdminLTETask Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $title
 * @property string $message
 * @property string $link
 * @property string $icon
 * @property int $seen
 * @property int $completed
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \AdminLTE\Model\Entity\User $user
 */
class AdminLTETask extends Entity
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
        'user_id' => true,
        'title' => true,
        'message' => true,
        'link' => true,
        'icon' => true,
        'seen' => true,
        'completed' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
