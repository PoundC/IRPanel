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
 * Chatrooms Model
 */
class ChatChatroomsTable extends Table
{
    public $validate = array(
        'name' => array(
            'rule' => 'alphanumeric',
            'required' => true,
            'allowEmpty' => false,
        ),
        'topic' => array(
            'rule' => 'alphanumeric',
            'required' => true,
            'allowEmpty' => false,
        ),
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('chat_chatrooms');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }
}
