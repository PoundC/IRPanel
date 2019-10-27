<?php
namespace AdminLTE\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdminLTEMenuNotification Entity
 *
 * @property int $id
 * @property string $menu_group
 * @property string $menu_title
 * @property int $notification_count
 * @property string $destination
 * @property string $user_id
 * @property string $role_id
 *
 * @property \AdminLTE\Model\Entity\MenuNotificationLog[] $admin_l_t_e_menu_notification_logs
 */
class MenuNotification extends Entity
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
        'menu_group' => true,
        'menu_title' => true,
        'notification_count' => true,
        'destination' => true,
        'user_id' => true,
        'role_id' => true,
        'admin_l_t_e_menu_notification_logs' => true
    ];
}
