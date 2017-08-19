<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 6:34 PM
 */

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Billing History Model
 */
class BillingHistoryTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('users_subscriptions', ['className' => 'Billing'])->setForeignKey('subscription_id')->setProperty('subscription');

        $this->setTable('users_subscriptions_history');
        $this->setDisplayField('messages');
        $this->setPrimaryKey('id');
    }
}