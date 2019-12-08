<?php
namespace IRPanelJams\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IRCJams Model
 *
 * @property \IRPanelJams\Model\Table\IRCUsersTable|\Cake\ORM\Association\BelongsTo $IRCUsers
 *
 * @method \IRPanelJams\Model\Entity\IRCJam get($primaryKey, $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJam newEntity($data = null, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJam[] newEntities(array $data, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJam|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJam saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJam[] patchEntities($entities, array $data, array $options = [])
 * @method \IRPanelJams\Model\Entity\IRCJam findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IRCJamsTable extends Table
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

        $this->setTable('i_r_c_jams');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->scalar('link')
            ->maxLength('link', 3000)
            ->requirePresence('link', 'create')
            ->allowEmptyString('link', false);

        $validator
            ->scalar('searchable')
            ->requirePresence('searchable', 'create')
            ->allowEmptyString('searchable', false);

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        $validator
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

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
        $rules->add($rules->existsIn(['i_r_c_users_id'], 'IRCUsers'));

        return $rules;
    }
}
