<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class MessagesTable extends Table
{
    public $validate = array(
        'closed' => array(
            'rule' => array('inList', array(1,2,3,4,5,6)),
            'allowEmpty' => false,
        ),
        'email' => array(
            'Valid Email' => array(
                'rule' => ['email'],
                'message' => 'Please enter a valid email'
            ),
            'required' => true,
            'allowEmpty' => false,
        ),
        'subject' => array(
            'rule' => 'alphanumeric',
            'required' => true,
            'allowEmpty' => false,
        ),
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

        // $this->belongsTo('Messages', array())->setForeignKey('message_id')->setProperty('message');

        $this->setTable('messages');
        $this->setDisplayField('subject');
        $this->setPrimaryKey('id');
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

    public function validationContact(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('email')
            ->add('email', 'valid', ['rule' => 'email'])
            ->notEmpty('email', 'This field is required');

        $validator
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        $validator
            ->add('tos_date', 'valid', ['rule' => 'datetime'])
            ->notEmpty('tos_date');

        return $validator;
    }

    public function validationReply(Validator $validator)
    {
        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        return $validator;
    }
}




