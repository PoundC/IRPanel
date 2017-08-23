<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StatsValues Model
 *
 * @property \App\Model\Table\StatsConfigsTable|\Cake\ORM\Association\BelongsTo $StatsConfigs
 *
 * @method \App\Model\Entity\StatsValue get($primaryKey, $options = [])
 * @method \App\Model\Entity\StatsValue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StatsValue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StatsValue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatsValue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StatsValue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StatsValue findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatsValuesTable extends Table
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

        $this->setTable('stats_values');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('StatsConfigs', [
            'foreignKey' => 'stats_config_id',
            'joinType' => 'INNER'
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
            ->requirePresence('interval_total', 'create')
            ->notEmpty('interval_total');

        $validator
            ->integer('interval_count')
            ->requirePresence('interval_count', 'create')
            ->notEmpty('interval_count');

        $validator
            ->numeric('total_total')
            ->requirePresence('total_total', 'create')
            ->notEmpty('total_total');

        $validator
            ->integer('total_count')
            ->requirePresence('total_count', 'create')
            ->notEmpty('total_count');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['stats_config_id'], 'StatsConfigs'));

        return $rules;
    }
}
