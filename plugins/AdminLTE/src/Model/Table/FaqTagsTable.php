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
class FaqtagsTable extends Table
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

        $this->hasMany('FaqAnswerTags', ['className' => 'AdminLTE\Model\Table\FaqAnswerTagsTable'])->setForeignKey('faq_tag_id')->setProperty('tags');

        $this->setTable('admin_l_t_e_faq_tags');
        $this->setDisplayField('tag');
        $this->setPrimaryKey('id');

        $this->addBehavior('Muffin/Slug.Slug', [
            'displayField'  => 'tag',
            'onUpdate'      => true,
            'maxLength'     => 2048,
        ]);
    }

    public function validationSend(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('tag', 'create')
            ->notEmpty('tag');

        return $validator;
    }
}
