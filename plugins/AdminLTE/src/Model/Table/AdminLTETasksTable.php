<?php
namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminLTETasks Model
 *
 * @property \AdminLTE\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \AdminLTE\Model\Entity\AdminLTETask get($primaryKey, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTETask newEntity($data = null, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTETask[] newEntities(array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTETask|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTETask saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTETask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTETask[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTETask findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdminLTETasksTable extends Table
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

        $this->setTable('admin_l_t_e_tasks');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'AdminLTE.Users'
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
            ->scalar('title')
            ->maxLength('title', 256)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->allowEmptyString('message', false);

        $validator
            ->scalar('link')
            ->maxLength('link', 1024)
            ->requirePresence('link', 'create')
            ->allowEmptyString('link', false);

        $validator
            ->scalar('icon')
            ->maxLength('icon', 32)
            ->requirePresence('icon', 'create')
            ->allowEmptyString('icon', false);

        $validator
            ->integer('seen')
            ->allowEmptyString('seen', false);

        $validator
            ->integer('completed')
            ->allowEmptyString('completed', false);

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
