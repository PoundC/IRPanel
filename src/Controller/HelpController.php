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
use Cake\Event\Event;

class HelpController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event) {

        parent::beforeFilter($event);

        $this->Auth->allow('help');
    }

    public function help($id = 0)
    {
        if($this->request->getMethod() == 'POST') {

            $data = $this->request->getData();

            $questionsTable = TableRegistry::get('faq_questions');
            $questionsQuery = $questionsTable->find('all', ['contain' => ['faq_answers', 'faq_answers.faq_topics']])
                                             ->where(['faq_topics.topic LIKE' => '%' . $data['search'] . '%'])
                                             ->orWhere(['faq_questions.question LIKE' => '%' . $data['search'] . '%'])
                                             ->orWhere(['faq_answers.answer LIKE' => '%' . $data['search'] . '%'])
                                             ->orWhere(['faq_answers.subject LIKE' => '%' . $data['search'] . '%']);

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

    public function topic($id = 0)
    {
        $topicsTable = TableRegistry::get('faq_topics');
        $topicsQuery = $topicsTable->find('all', ['contain' => ['faq_answers', 'faq_answers.faq_topics']])->where(['faq_topics.id' => $id]);
        $topicsResults = $topicsQuery->first();

        $this->set(compact('topicsResults'));
    }

    public function tag($id = 0)
    {
        $tagsTable = TableRegistry::get('faq_tags');
        $tagsQuery = $tagsTable->find('all', ['contain' => ['faq_answer_tags', 'faq_answer_tags.faq_tags', 'faq_answer_tags.faq_answers', 'faq_answer_tags.faq_answers.faq_topics']])->where(['faq_tags.id' => $id]);
        $tagsResults = $tagsQuery->first();

        $this->set(compact('tagsResults'));
    }

    public function markdown()
    {
        if($this->request->getMethod() == 'POST') {

            $markdownthis = $this->request->getData();
            $markdownthis = $markdownthis['message_preview'];

            $this->set('markdownthis', $markdownthis);
        }
    }

    public function senduser($id = 0)
    {
        $chatRoomsTable = TableRegistry::get('Chatrooms');
        $chatRoomsQuery = $chatRoomsTable->find('all')->where(['chatrooms.name' => $this->request->getQuery('redirect')]);
        $chatRoomsResult = $chatRoomsQuery->first();

        $helpTabsTable = TableRegistry::get('helptabs');
        $helpTabsQuery = $helpTabsTable->find('all')->where(['faq_answer_id' => $id])->limit(1);

        if($helpTabsQuery->count() == 0) {

            $helpTabsEntity = $helpTabsTable->newEntity([
                'chatroom_id' => $chatRoomsResult->id,
                'faq_answer_id' => $id,
                'created' => new \DateTime('now')
            ]);

            $helpTabsTable->save($helpTabsEntity);
        }

        $this->redirect('/chat/' . $this->request->getQuery('redirect') . '?search=' . $this->request->getQuery('search'));
    }
}