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

namespace AdminLTE\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Helptabs Model
 */
class ChatHelptabsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Faq_Answers', array())->setForeignKey('faq_answer_id')->setProperty('answer');
        $this->belongsTo('ChatChatrooms', array())->setForeignKey('chatroom_id')->setProperty('room');

        $this->setTable('chat_helptabs');
        $this->setDisplayField('Faq_Answers.topic');
        $this->setPrimaryKey('id');
    }

    public function validationSend(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('faq_answer_id', 'create')
            ->notEmpty('faq_answer_id');

        $validator
            ->requirePresence('chatroom_id', 'create')
            ->notEmpty('chatroom_id');

        return $validator;
    }
}
