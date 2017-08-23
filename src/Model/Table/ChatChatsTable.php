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
 * Chats Model
 */
class ChatChatsTable extends Table
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
        $this->belongsTo('ChatChatrooms', array())->setForeignKey('chatroom_id')->setProperty('room');

        $this->setTable('chat_chats');
        $this->setDisplayField('message');
        $this->setPrimaryKey('id');
    }

    public function validationSend(Validator $validator)
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

    public function validationReceive(Validator $validator)
    {


        return $validator;
    }
}