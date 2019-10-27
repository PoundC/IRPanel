<?php
namespace AdminLTE\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property string $account_id
 * @property string $subject
 * @property string $message
 * @property int $message_id
 * @property int $read
 * @property int $replied
 * @property int $priority
 * @property int $topic
 * @property int $closed
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $to_user_id
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Message[] $messages
 * @property \App\Model\Entity\ToUser $to_user
 */
class Messaging extends Entity
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
        'subject' => true,
        'message' => true,
        'message_id' => true,
        'read' => true,
        'recipient_read' => true,
        'replied' => true,
        'priority' => true,
        'user_deleted' => true,
        'recipient_deleted' => true,
        'created' => true,
        'modified' => true,
        'to_user_id' => true
    ];
}
