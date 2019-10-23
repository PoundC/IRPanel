<?php
namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminLTEMenuNotifications Model
 *
 * @property \AdminLTE\Model\Table\DestinationsTable|\Cake\ORM\Association\BelongsTo $Destinations
 * @property \AdminLTE\Model\Table\AdminLTEMenuNotificationLogsTable|\Cake\ORM\Association\HasMany $AdminLTEMenuNotificationLogs
 *
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification get($primaryKey, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification newEntity($data = null, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification[] newEntities(array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminLTE\Model\Entity\AdminLTEMenuNotification findOrCreate($search, callable $callback = null, $options = [])
 */
class AdminLTEMenuNotificationsTable extends Table
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

        $this->setTable('admin_l_t_e_menu_notifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('AdminLTEMenuNotificationLogs', [
            'foreignKey' => 'admin_l_t_e_menu_notification_id',
            'className' => 'AdminLTE.AdminLTEMenuNotificationLogs'
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
            ->scalar('menu_group')
            ->maxLength('menu_group', 32)
            ->requirePresence('menu_group', 'create')
            ->allowEmptyString('menu_group', false);

        $validator
            ->scalar('menu_title')
            ->maxLength('menu_title', 32)
            ->requirePresence('menu_title', 'create')
            ->allowEmptyString('menu_title', false);

        $validator
            ->integer('notification_count')
            ->requirePresence('notification_count', 'create')
            ->allowEmptyString('notification_count', false);

        $validator
            ->scalar('destination')
            ->requirePresence('destination', 'create')
            ->allowEmptyString('destination', false);

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
        return $rules;
    }
}
