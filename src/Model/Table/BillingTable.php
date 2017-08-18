<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:43 AM
 */

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Chats Model
 */
class BillingTable extends Table
{
    public $validate = array(
        'message' => array(
            'rule' => 'alphanumeric',
            'required' => true,
            'allowEmpty' => false,
        ),
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Users', array())->setForeignKey('user_id')->setProperty('user');

        $this->setTable('users_subscriptions');
        $this->setDisplayField('messages');
        $this->setPrimaryKey('id');
    }

    public function validationSubscribe(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id');

        $validator
            ->requirePresence('room_id', 'create')
            ->notEmpty('room_id');

        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        return $validator;
    }
}