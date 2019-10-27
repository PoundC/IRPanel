<?php
namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StatsConfig Model
 *
 * @property \AdminLTE\Model\Table\StatsBasicsTable|\Cake\ORM\Association\HasMany $StatsBasics
 * @property \AdminLTE\Model\Table\StatsValuesTable|\Cake\ORM\Association\HasMany $StatsValues
 *
 * @method \AdminLTE\Model\Entity\StatsConfig get($primaryKey, $options = [])
 * @method \AdminLTE\Model\Entity\StatsConfig newEntity($data = null, array $options = [])
 * @method \AdminLTE\Model\Entity\StatsConfig[] newEntities(array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\StatsConfig|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\StatsConfig patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\StatsConfig[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\StatsConfig findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatsConfigTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('admin_l_t_e_stats_config');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->setEntityClass('AdminLTE\Model\Entity\StatsConfig');

        $this->addBehavior('Timestamp');

        $this->hasMany('StatsBasics', [
            'foreignKey' => 'stats_config_id'
        ]);
        $this->hasMany('StatsValues', [
            'foreignKey' => 'stats_config_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('stats_table', 'create')
            ->notEmpty('stats_table');

        $validator
            ->requirePresence('stats_column', 'create')
            ->notEmpty('stats_column');

        $validator
            ->requirePresence('stats_type', 'create')
            ->notEmpty('stats_type');

        return $validator;
    }
}
