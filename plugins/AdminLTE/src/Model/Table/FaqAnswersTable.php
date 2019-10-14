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
 * Answers Model
 */
class FaqAnswersTable extends Table
{
    public $validate = array(
        'topic' => array(
            'rule' => 'alphanumeric',
            'required' => true,
            'allowEmpty' => false,
        )
    );

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('AdminLTE.FaqTopics', array())->setForeignKey('faq_topic_id')->setProperty('topic');
        $this->hasMany('FaqQuestions', array())->setForeignKey('faq_answer_id')->setProperty('questions');
        $this->hasMany('FaqAnswerTaga', array())->setForeignKey('faq_answer_id')->setProperty('answer_tags');

        $this->addBehavior('Muffin/Slug.Slug', [
            'displayField'  => 'subject',
            'onUpdate'      => true
        ]);

        $this->setTable('faq_answers');
        $this->setDisplayField('faq_topics.topic');
        $this->setPrimaryKey('id');
    }

    public function validationSend(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('topic', 'create')
            ->notEmpty('topic');

        $validator
            ->requirePresence('answer', 'create')
            ->notEmpty('answer');

        return $validator;
    }
}
