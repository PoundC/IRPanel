<?php
namespace AdminLTE\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdminLTERecipient Entity
 *
 * @property int $id
 * @property int $message_id
 * @property string $user_id
 * @property int $to
 * @property int $cc
 * @property int $bcc
 *
 * @property \AdminLTE\Model\Entity\Message $message
 * @property \AdminLTE\Model\Entity\User $user
 */
class Recipient extends Entity
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
        'message_id' => true,
        'user_id' => true,
        'to' => true,
        'cc' => true,
        'bcc' => true,
        'message' => true,
        'user' => true
    ];
}
