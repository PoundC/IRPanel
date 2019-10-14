<?php
namespace AdminLTE\Model\Entity;

use Cake\ORM\Entity;

/**
 * StatsConfig Entity
 *
 * @property int $id
 * @property string $stats_table
 * @property string $stats_column
 * @property string $stats_type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\StatsBasic[] $stats_basics
 * @property \App\Model\Entity\StatsValue[] $stats_values
 */
class StatsConfig extends Entity
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
        '*' => true,
        'id' => false
    ];
}
