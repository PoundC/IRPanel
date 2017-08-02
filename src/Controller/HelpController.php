<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use App\Utility\Generator;
use Cake\Utility\Text;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class HelpController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function help($id = 0)
    {
        if($this->request->getMethod() == 'POST') {

            $data = $this->request->getData();

            $questionsTable = TableRegistry::get('faq_questions');
            $questionsQuery = $questionsTable->find('all', ['contain' => ['faq_answers', 'faq_answers.faq_topics']])
                                             ->where(['faq_topics.topic LIKE' => '%' . $data['search'] . '%'])
                                             ->orWhere(['faq_questions.question LIKE' => '%' . $data['search'] . '%'])
                                             ->orWhere(['faq_answers.answer LIKE' => '%' . $data['search'] . '%']);

            $searchResults = $questionsQuery->count();

            $tableAlias = $questionsTable->getAlias();
            $this->set($tableAlias, $this->paginate($questionsQuery));
            $this->set('tableAlias', $tableAlias);
            $this->set('_serialize', [$tableAlias, 'tableAlias']);

            $this->set(compact('searchResults'));
        }
        else {

            if($id == 0) {

                $topicsTable = TableRegistry::get('faq_topics');
                $topicsQuery = $topicsTable->find('all', ['contain' => ['faq_answers']]);
                $topicsResults = $topicsQuery->all();

                $this->set(compact('topicsResults'));
            }
            else {

                $faqAnswerTable = TableRegistry::get('faq_answers');
                $faqAnswerQuery = $faqAnswerTable->find('all', ['contain' => ['faq_questions', 'faq_topics', 'faq_answer_tags', 'faq_answer_tags.faq_tags']])->where(['faq_answers.id' => $id])->limit(1);
                $answerResult = $faqAnswerQuery->first();

                $this->set(compact('answerResult'));
            }
        }
    }
}