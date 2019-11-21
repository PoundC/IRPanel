<?php
namespace IRPanelMedia\Model\Entity;

use Cake\ORM\Entity;

/**
 * IRCMediaGallery Entity
 *
 * @property int $id
 * @property int $i_r_c_media_id
 * @property string $media_url
 * @property string $media_type
 *
 * @property \IRPanelMedia\Model\Entity\IRCMedia $i_r_c_media
 */
class IRCMediaGallery extends Entity
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
        'i_r_c_media_id' => true,
        'media_url' => true,
        'media_type' => true,
        'i_r_c_media' => true
    ];
}
