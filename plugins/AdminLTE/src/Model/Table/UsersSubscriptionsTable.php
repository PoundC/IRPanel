<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:43 AM
 */

namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * UsersSubscriptionsTable Model
 */
class UsersSubscriptionsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('admin_l_t_e_users_subscriptions');
        $this->setDisplayField('messages');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'className' => 'AdminLTE\Model\Table\UsersTable',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('users_subscriptions_history', ['className' => 'UsersSubscriptionsHistory'])->setForeignKey('subscription_id')->setProperty('subscription');
    }
}
