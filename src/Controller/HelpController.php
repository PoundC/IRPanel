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

            $this->set('title', 'Help & FAQ');
            $this->set(compact('searchResults'));
        }
        else {

            if($id == '0') {

                $topicsTable = TableRegistry::get('faq_topics');
                $topicsQuery = $topicsTable->find('all', ['contain' => ['faq_answers']]);
                $topicsResults = $topicsQuery->all();

                $this->set('title', 'Help & FAQ');
                $this->set(compact('topicsResults'));
            }
            else {

                $faqAnswerTable = TableRegistry::get('faq_answers');
                $faqAnswerQuery = $faqAnswerTable->find('slugged', ['slug' => $id, 'contain' => ['faq_questions', 'faq_topics', 'faq_answer_tags', 'faq_answer_tags.faq_tags']])->limit(1);
                $answerResult = $faqAnswerQuery->first();

                $this->set('title', $answerResult->subject);
                $this->set(compact('answerResult'));
            }
        }
    }

    public function convert($id = 0)
    {
        $answerTable = TableRegistry::get('faq_answers');
        $tagsTable = TableRegistry::get('faq_tags');
        $tagAnswersTable = TableRegistry::get('faq_answer_tags');
        $questionsTable = TableRegistry::get('faq_questions');

        $topicsTable = TableRegistry::get('faq_topics');
        $topicsQuery = $topicsTable->find('all');
        $topics = $topicsQuery->find('list');

        $tagsQuery = $tagsTable->find('all');
        $tags = $tagsQuery->find('list');

        if($this->request->getMethod() == 'POST') {

            if($id == 0) {

                $data = $this->request->getData();

                $answerSubject = $data['subject'];
                $answerMarkdown = $data['answer'];
                $answerTopicId = $data['faq_topics']['topic'];
                $answerTags = array();

                foreach ($data['faq_tags']['tag'] as $tagKey => $tagValue) {

                    if (is_numeric($tagValue) == false) {

                        $tagQuery = $tagsTable->find('all')->where(['tag' => $tagValue])->limit(1);
                        $tagResult = $tagQuery->first();

                        if (isset($tagResult->id) == false) {

                            $tagEntity = $tagsTable->newEntity([
                                'tag' => $tagValue,
                                'created' => new \DateTime('now')
                            ]);
                            $tagResult = $tagsTable->save($tagEntity);

                            $answerTags[] = $tagResult->id;
                        } else {

                            $answerTags[] = $tagResult->id;
                        }
                    } else {

                        $answerTags[] = $tagValue;
                    }
                }

                $answerEntity = $answerTable->newEntity([
                    'faq_topic_id' => $answerTopicId,
                    'subject' => $answerSubject,
                    'answer' => $answerMarkdown,
                    'created' => new \DateTime('now')
                ]);
                $answerResult = $answerTable->save($answerEntity);

                foreach ($answerTags as $tagId) {

                    $faqAnswerTagEntity = $tagAnswersTable->newEntity([
                        'faq_answer_id' => $answerResult->id,
                        'faq_tag_id' => $tagId,
                        'created' => new \DateTime('now')
                    ]);
                    $faqAnswerTagResult = $tagAnswersTable->save($faqAnswerTagEntity);
                }

                foreach ($data['questions'] as $question) {

                    $questionQuery = $questionsTable->find('all')->where(['question' => $question, 'faq_answer_id' => $answerResult->id])->limit(1);
                    $questionResult = $questionQuery->first();

                    if (isset($questionResult) == false) {

                        $questionEntity = $questionsTable->newEntity([
                            'faq_answer_id' => $answerResult->id,
                            'question' => $question,
                            'created' => new \DateTime('now')
                        ]);
                        $questionsTable->save($questionEntity);
                    }
                }

                $this->redirect('/convertfaq/' . $answerResult->id);
            }
        }
        else if($this->request->getMethod() == 'PUT') {

            $data = $this->request->getData();

            //print_r($data); die();

            $answerSubject = $data['subject'];
            $answerMarkdown = $data['answer'];
            $answerTopicId = $data['faq_topics']['topic'];

            $answerQuery = $answerTable->find('all')->where(['faq_answers.id' => $id]);
            $answerResult = $answerQuery->first();

            $answerResult->set('subject', $answerSubject);
            $answerResult->set('answer', $answerMarkdown);
            $answerResult->set('faq_topic_id', $answerTopicId);

            $answerTable->save($answerResult);

            // save tags
            // get tag ids, check if tag id is associated with faq_answer_id, if not add...

            $answerTagsTable = TableRegistry::get('faq_answer_tags');
            $answerTagsQuery = $answerTagsTable->find('all')->where(['faq_answer_id' => $id]);
            $answerTags = $answerTagsQuery->all();

            foreach ($data['faq_tags']['tag'] as $key => $value) {

                //print_r($value);

                $foundTag = false;

                foreach ($answerTags as $answerTagKey => $answerTagValue) {

                    if ($answerTagValue->faq_tag_id == $value) {

                        $foundTag = true;
                        break;
                    }
                }

                if($foundTag == false) {

                    if(is_numeric($value)) {

                        $tagId = $value;
                    }
                    else {

                        $tagEntity = $tagsTable->newEntity([
                            'tag' => $value,
                            'created' => new \DateTime('now')
                        ]);
                        $tagResult = $tagsTable->save($tagEntity);

                        $tagId = $tagResult->id;
                    }

                    $faqAnswerTagEntity = $tagAnswersTable->newEntity([
                        'faq_answer_id' => $answerResult->id,
                        'faq_tag_id' => $tagId,
                        'created' => new \DateTime('now')
                    ]);
                    $faqAnswerTagResult = $tagAnswersTable->save($faqAnswerTagEntity);
                }
            }

            $answerQuestionsTable = TableRegistry::get('faq_questions');
            $answerQuestionsQuery = $answerQuestionsTable->find('all')->where(['faq_answer_id' => $id]);
            $answerQuestionsResult = $answerQuestionsQuery->all();

            foreach($data['questions'] as $question) {

                $foundQuestion = false;

                foreach($answerQuestionsResult as $answerQuestionKey => $answerQuestionValue) {

                    if($answerQuestionValue->question == $question) {

                        $foundQuestion = true;
                        break;
                    }
                }

                if($foundQuestion == false) {

                    $questionEntity = $questionsTable->newEntity([
                        'faq_answer_id' => $answerResult->id,
                        'question' => $question,
                        'created' => new \DateTime('now')
                    ]);
                    $questionsTable->save($questionEntity);
                }
            }

            $this->redirect('/convertfaq/' . $answerResult->id);
        }
        else {

            if($id == 0) {

                $replyId = $this->request->getQuery('reply');

                if($replyId > 0) {

                    $messagesTable = TableRegistry::get('Messages');
                    $messagesQuery = $messagesTable->find('all', ['contain' => ['ParentMessages']])->where(['messages.id' => $replyId])->limit(1);
                    $messageResult = $messagesQuery->first();

                    $answerEntity = $answerTable->newEntity([
                        'subject' => $messageResult->messages->subject,
                        'answer'  => $messageResult->message
                    ]);
                }
                else {

                    $answerEntity = $answerTable->newEntity();
                }
            }
            else {

                $answerQuery = $answerTable->find('all', ['contain' => ['faq_answer_tags', 'faq_questions']])->where(['faq_answers.id' => $id]);
                $answerEntity = $answerQuery->first();

                $answerTags = array();
                $answerQuestions = array();

                foreach($answerEntity->answer_tags as $key => $value) {

                    $answerTags[] = $value->faq_tag_id;
                }

                foreach($answerEntity->questions as $key => $value) {

                    $answerQuestions[] = $value->question;
                }
            }
        }

        if(isset($answerTags)) {

            $this->set('answerTags', $answerTags);
        }

        if(isset($answerQuestions)) {

            $this->set('answerQuestions', $answerQuestions);
        }

        $this->set('topics', $topics);
        $this->set('tags', $tags);
        $this->set(compact('answerEntity', 'id'));

        $this->set('title', 'Convert Ticket to FAQ');
    }

    public function topic($id = 0)
    {
        $topicsTable = TableRegistry::get('faq_topics');
        $topicsQuery = $topicsTable->find('all', ['slug' => $id, 'contain' => ['faq_answers', 'faq_answers.faq_topics']]);
        $topicsResults = $topicsQuery->first();

        $this->set('title', $topicsResults->topic);
        $this->set(compact('topicsResults'));
    }

    public function tag($id = 0)
    {
        $tagsTable = TableRegistry::get('faq_tags');
        $tagsQuery = $tagsTable->find('all', ['slug' => $id, 'contain' => ['faq_answer_tags', 'faq_answer_tags.faq_tags', 'faq_answer_tags.faq_answers', 'faq_answer_tags.faq_answers.faq_topics']]);
        $tagsResults = $tagsQuery->first();

        $this->set('title', $tagsResults->tag);
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