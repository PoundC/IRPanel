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
 * Questions Model
 */
class FaqQuestionsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('AdminLTE.FaqAnswers', array())->setForeignKey('faq_answer_id')->setProperty('answer');

        $this->setTable('faq_questions');
        $this->setDisplayField('question');
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
            ->requirePresence('question', 'create')
            ->notEmpty('question');

        return $validator;
    }
}
