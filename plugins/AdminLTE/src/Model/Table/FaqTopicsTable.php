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
 * Faqtags Model
 */
class FaqTopicsTable extends Table
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

        $this->hasMany('FaqAnswers', ['className' => 'AdminLTE\Model\Table\FaqAnswersTable'])->setForeignKey('faq_topic_id')->setProperty('answers')->setDependent(true);

        $this->setTable('admin_l_t_e_faq_topics');
        $this->setDisplayField('topic');
        $this->setPrimaryKey('id');

        $this->addBehavior('Muffin/Slug.Slug', [
            'displayField'  => 'topic',
            'onUpdate'      => true
        ]);
    }

    public function TopicsTableTest() {


    }

    public function validationSend(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('topic', 'create')
            ->notEmpty('topic');

        return $validator;
    }
}
