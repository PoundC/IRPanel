<?php
namespace IRPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comment Entity
 *
 * @property int $id
 * @property int $i_r_c_users_id
 * @property string $table_name
 * @property int $table_row_id
 * @property int $comment_id
 * @property string $comment
 *
 * @property \IRPanel\Model\Entity\IRCUser $i_r_c_user
 * @property \IRPanel\Model\Entity\TableRow $table_row
 * @property \IRPanel\Model\Entity\Comment[] $comments
 */
class Comment extends Entity
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
        'table_name' => true,
        'table_row_id' => true,
        'comment_id' => true,
        'comment' => true,
        'i_r_c_user' => true,
        'comments' => true
    ];
}
