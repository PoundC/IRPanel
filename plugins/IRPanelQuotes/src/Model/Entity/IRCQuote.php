<?php
namespace IRPanelQuotes\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCQuote Entity
 *
 * @property int $id
 * @property int $i_r_c_user_id
 * @property string $quote
 * @property \Cake\I18n\FrozenTime $created
 * @property string $topic
 *
 * @property \IRPanelQuotes\Model\Entity\IRCUser $i_r_c_user
 */
class IRCQuote extends Entity
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
        'i_r_c_user_id' => true,
        'quote' => true,
        'created' => true,
        'topic' => true,
        'i_r_c_user' => true
    ];
}
