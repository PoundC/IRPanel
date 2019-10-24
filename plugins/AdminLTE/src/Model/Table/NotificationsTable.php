<?php
namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notifications Model
 *
 * @property \AdminLTE\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Roles
 * @property \AdminLTE\Model\Table\AdminLTENotificationLogsTable|\Cake\ORM\Association\HasMany $AdminLTENotificationLogs
 * @property \AdminLTE\Model\Table\AdminLTEPushNotificationsTable|\Cake\ORM\Association\HasMany $AdminLTEPushNotifications
 *
 * @method \AdminLTE\Model\Entity\Notification get($primaryKey, $options = [])
 * @method \AdminLTE\Model\Entity\Notification newEntity($data = null, array $options = [])
 * @method \AdminLTE\Model\Entity\Notification[] newEntities(array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\Notification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\Notification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\Notification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\Notification[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\Notification findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NotificationsTable extends Table
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

        $this->setTable('notifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'AdminLTE.Users'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
            'className' => 'AdminLTE.Roles'
        ]);
        $this->hasMany('AdminLTENotificationLogs', [
            'foreignKey' => 'notification_id',
            'className' => 'AdminLTE.AdminLTENotificationLogs'
        ]);
        $this->hasMany('AdminLTEPushNotifications', [
            'foreignKey' => 'notification_id',
            'className' => 'AdminLTE.AdminLTEPushNotifications'
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
            ->scalar('type')
            ->maxLength('type', 32)
            ->allowEmptyString('type', false);

        $validator
            ->scalar('message')
            ->maxLength('message', 1024)
            ->allowEmptyString('message', false);

        $validator
            ->scalar('destination')
            ->requirePresence('destination', 'create')
            ->allowEmptyString('destination', false);

        $validator
            ->integer('total_count')
            ->allowEmptyString('total_count', false);

        $validator
            ->scalar('link')
            ->maxLength('link', 1024)
            ->allowEmptyString('link', false);

        $validator
            ->scalar('color')
            ->requirePresence('color', 'create')
            ->allowEmptyString('color', false);

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
