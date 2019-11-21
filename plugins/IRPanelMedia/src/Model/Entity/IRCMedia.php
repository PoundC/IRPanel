<?php
namespace IRPanelMedia\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCMedia Entity
 *
 * @property int $id
 * @property int $i_r_c_users_id
 * @property string $link
 * @property string $searchable
 * @property string $description
 * @property string $title
 * @property string $media_type
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \IRPanelMedia\Model\Entity\IRCUser $i_r_c_user
 * @property \IRPanelMedia\Model\Entity\IRCMediaGallery[] $i_r_c_media_galleries
 */
class IRCMedia extends Entity
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
        'media_type' => true,
        'created' => true,
        'i_r_c_user' => true,
        'i_r_c_media_galleries' => true
    ];
}
