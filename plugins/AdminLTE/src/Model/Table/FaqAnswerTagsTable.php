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
 * Faqanswertags Model
 */
class FaqAnswerTagsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('FaqAnswers', ['className' => 'AdminLTE\Model\Table\FaqAnswersTable'])->setForeignKey('faq_answer_id')->setProperty('answer');
        $this->belongsTo('FaqTags', ['className' => 'AdminLTE\Model\Table\FaqTagsTable'])->setForeignKey('faq_tag_id')->setProperty('tags');

        $this->setTable('admin_l_t_e_faq_answer_tags');
        $this->setDisplayField('admin_l_t_e_faq_tags.tag');
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
            ->requirePresence('faq_tag_id', 'create')
            ->notEmpty('faq_tag_id');

        return $validator;
    }
}
