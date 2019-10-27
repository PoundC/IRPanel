<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 6:34 PM
 */

namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Billing History Model
 */
class UsersSubscriptionsHistoryTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('users_subscriptions', ['className' => 'UsersSubscriptions'])->setForeignKey('subscription_id')->setProperty('subscription');

        $this->setTable('admin_l_t_e_users_subscriptions_history');
        $this->setDisplayField('messages');
        $this->setPrimaryKey('id');
    }
}
