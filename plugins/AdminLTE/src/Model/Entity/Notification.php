<?php
namespace AdminLTE\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notification Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $type
 * @property string $message
 * @property \Cake\I18n\FrozenTime $created
 * @property string $destination
 * @property string $role_id
 * @property int $total_count
 * @property string $link
 *
 * @property \AdminLTE\Model\Entity\User $user
 * @property \AdminLTE\Model\Entity\Role $role
 * @property \AdminLTE\Model\Entity\AdminLTENotificationLog[] $admin_l_t_e_notification_logs
 */
class Notification extends Entity
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
        'type' => true,
        'message' => true,
        'created' => true,
        'destination' => true,
        'role_id' => true,
        'total_count' => true,
        'link' => true,
        'user' => true,
        'role' => true,
        'admin_l_t_e_notification_logs' => true
    ];
}
