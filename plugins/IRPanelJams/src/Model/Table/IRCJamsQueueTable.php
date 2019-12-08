<?php
namespace IRPanelJams\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCJamsQueue Model
 *
 * @property \IRPanelJams\Model\Table\IRCJamsTable|\Cake\ORM\Association\BelongsTo $IRCJams
 * @property \IRPanelJams\Model\Table\IRCUsersTable|\Cake\ORM\Association\BelongsTo $IRCUsers
 *
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue get($primaryKey, $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue newEntity($data = null, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue[] newEntities(array $data, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJamsQueue findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCJamsQueueTable extends Table
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

        $this->setTable('i_r_c_jams_queue');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('IRCJams', [
            'foreignKey' => 'i_r_c_jam_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelJams.IRCJams'
        ]);
        $this->belongsTo('IRCUsers', [
            'foreignKey' => 'i_r_c_users_id',
            'joinType' => 'INNER',
            'className' => 'IRPanelJams.IRCUsers'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('played')
            ->requirePresence('played', 'create')
            ->allowEmptyString('played', false);

        $validator
            ->dateTime('playedts')
            ->requirePresence('playedts', 'create')
            ->allowEmptyDateTime('playedts', false);

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
        $rules->add($rules->existsIn(['i_r_c_jam_id'], 'IRCJams'));
        $rules->add($rules->existsIn(['i_r_c_users_id'], 'IRCUsers'));

        return $rules;
    }
}
