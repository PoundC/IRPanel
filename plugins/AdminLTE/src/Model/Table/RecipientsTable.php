<?php
namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminLTERecipients Model
 *
 * @property \AdminLTE\Model\Table\MessagesTable|\Cake\ORM\Association\BelongsTo $Messages
 * @property \AdminLTE\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \AdminLTE\Model\Entity\Recipient get($primaryKey, $options = [])
 * @method \AdminLTE\Model\Entity\Recipient newEntity($data = null, array $options = [])
 * @method \AdminLTE\Model\Entity\Recipient[] newEntities(array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\Recipient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\Recipient saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\Recipient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\Recipient[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\Recipient findOrCreate($search, callable $callback = null, $options = [])
 */
class RecipientsTable extends Table
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

        $this->setTable('admin_l_t_e_recipients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->setEntityClass('AdminLTE\Model\Entity\Recipient');

        $this->belongsTo('Messages', [
            'foreignKey' => 'message_id',
            'joinType' => 'INNER',
            'className' => 'AdminLTE.Messages'
        ]);
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
            ->integer('to')
            ->allowEmptyString('to', false);

        $validator
            ->integer('cc')
            ->allowEmptyString('cc', false);

        $validator
            ->integer('bcc')
            ->allowEmptyString('bcc', false);

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
        $rules->add($rules->existsIn(['message_id'], 'Messages'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
