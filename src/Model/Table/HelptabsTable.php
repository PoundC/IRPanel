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
 * Helptabs Model
 */
class HelptabsTable extends Table
{
    public $validate = array(
        'tag' => array(
            'rule' => 'alphanumeric',
            'required' => true,
            'allowEmpty' => false,
        )
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Answers', array())->setForeignKey('answer_id')->setProperty('answer');
        $this->belongsTo('Chatrooms', array())->setForeignKey('chatroom_id')->setProperty('room');

        $this->setTable('helptabs');
        $this->setDisplayField('Answers.topic');
        $this->setPrimaryKey('id');
    }

    public function validationSend(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('answer_id', 'create')
            ->notEmpty('answer_id');

        $validator
            ->requirePresence('chatroom_id', 'create')
            ->notEmpty('chatroom_id');

        return $validator;
    }
}