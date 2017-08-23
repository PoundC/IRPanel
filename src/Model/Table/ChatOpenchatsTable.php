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
class ChatOpenchatsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Users', array())->setForeignKey('user_id')->setProperty('user');
        $this->belongsTo('ChatChatrooms', array())->setForeignKey('chatroom_id')->setProperty('room');

        $this->setTable('chat_openchats');
        $this->setDisplayField('active');
        $this->setPrimaryKey('id');
    }
}