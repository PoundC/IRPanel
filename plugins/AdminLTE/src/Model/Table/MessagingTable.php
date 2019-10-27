<?php
namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\ORM\Table;

/**
 * Messaging Model
 *
 * @property \App\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\MessagesTable|\Cake\ORM\Association\BelongsTo $Messages
 * @property \App\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Recipients
 * @property \App\Model\Table\MessagesTable|\Cake\ORM\Association\HasMany $Replies
 *
 * @method \App\Model\Entity\Message get($primaryKey, $options = [])
 * @method \App\Model\Entity\Message newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Message[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Message|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Message|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Message patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Message[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Message findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MessagingTable extends Table
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

        $this->setTable('admin_l_t_e_messaging');
        $this->setDisplayField('subject');
        $this->setPrimaryKey('id');
        $this->setEntityClass('AdminLTE\Model\Entity\Messaging');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'className' => 'AdminLTE\Model\Table\UsersTable',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Messaging', [
            'foreignKey' => 'messaging_id',
            'joinType' => 'INNER',
            'propertyName' => 'messaging'

        ]);
        $this->belongsTo('Recipients', [
            'className' => 'AdminLTE\Model\Table\UsersTable',
            'foreignKey' => 'to_user_id',
            'joinType' => 'INNER',
            'propertyName' => 'recipients'

        ]);
        $this->hasMany('Replies', [
            'className' => 'Messaging',
            'foreignKey' => 'messaging_id',
            'propertyName' => 'replies'
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
            ->scalar('subject')
            ->maxLength('subject', 2048)
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        return $validator;
    }

    public function validationSupport(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('closed', 'create')
            ->notEmpty('closed');

        $validator
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

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
        $rules->add($rules->existsIn(['to_user_id'], 'Users'));

        return $rules;
    }
}
