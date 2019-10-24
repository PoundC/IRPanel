<?php
namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminLTEPushNotifications Model
 *
 * @property \AdminLTE\Model\Table\NotificationsTable|\Cake\ORM\Association\BelongsTo $Notifications
 * @property \AdminLTE\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification get($primaryKey, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification newEntity($data = null, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification[] newEntities(array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEPushNotification findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdminLTEPushNotificationsTable extends Table
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

        $this->setTable('admin_l_t_e_push_notifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Notifications', [
            'foreignKey' => 'notification_id',
            'joinType' => 'INNER',
            'className' => 'AdminLTE.Notifications'
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
        $rules->add($rules->existsIn(['notification_id'], 'Notifications'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
