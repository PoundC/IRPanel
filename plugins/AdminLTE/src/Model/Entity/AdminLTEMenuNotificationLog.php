<?php
namespace AdminLTE\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdminLTEMenuNotificationLog Entity
 *
 * @property int $id
 * @property int $admin_l_t_e_menu_notification_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \AdminLTE\Model\Entity\AdminLTEMenuNotification $admin_l_t_e_menu_notification
 * @property \AdminLTE\Model\Entity\User $user
 */
class AdminLTEMenuNotificationLog extends Entity
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
        'admin_l_t_e_menu_notification_id' => true,
        'user_id' => true,
        'created' => true,
        'admin_l_t_e_menu_notification' => true,
        'user' => true
    ];
}
