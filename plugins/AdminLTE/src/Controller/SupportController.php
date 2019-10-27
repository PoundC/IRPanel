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
namespace AdminLTE\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use AdminLTE\Utility\Generator;
use Cake\Utility\Text;
use Cake\Event\Event;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SupportController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event) {

        parent::beforeFilter($event);

        $this->Auth->allow('contact');
    }

    public function view($id)
    {
        $usersTable = TableRegistry::get(Configure::read('Users.table'));
        $query = $usersTable->find('all')->where(['users.id' => $this->Auth->user('id')])->limit(1);
        $user = $query->first();

        $messagesTable = TableRegistry::get('AdminLTE.Messages');
        $messagesQuery = $messagesTable->find('all', ['contain' => ['Users']])->where(['messages.id' => $id])->limit(1)->orderAsc('messages.created');;
        $message = $messagesQuery->first();

        $repliesQuery = $messagesTable->find('all', ['contain' => ['Users']])->where(['messages.message_id' => $id])->orderAsc('messages.created');;
        $replies = $repliesQuery->all();

        $messageFromQuery = $usersTable->find('all')->where(['users.id' => $message->user_id])->limit(1);
        $messageFromUser = $messageFromQuery->first();

        $isAuthorized = false;

        if($user->role == 'admin') {

            $isAuthorized = true;
        }
        else {

            if($message->user_id == $user->id) {

                $isAuthorized = true;
            }
        }

        if($isAuthorized == false) {

            $this->Flash->error('You are not authorized to view that ticket.');
            $this->redirect($this->referer());
        }
        else {

            if($this->request->getMethod() == 'POST' || $this->request->getQuery('search') != '') {

                if($this->request->getMethod() == 'GET') {

                    $data['search'] = $this->request->getQuery('search');
                }
                else {

                    $data = $this->request->getData();
                }

                $questionsTable = TableRegistry::get('AdminLTE.faq_questions');
                $questionsQuery = $questionsTable->find('all', ['contain' => ['faq_answers', 'faq_answers.faq_topics']])
                    ->where(['faq_topics.topic LIKE' => '%' . $data['search'] . '%'])
                    ->orWhere(['faq_questions.question LIKE' => '%' . $data['search'] . '%'])
                    ->orWhere(['faq_answers.answer LIKE' => '%' . $data['search'] . '%']);

                $searchQuery = $data['search'];

                $searchResults = $questionsQuery->count();

                $this->set('searchResults', $searchResults);
                $this->set('searchQuery', $searchQuery);

                $tableAlias = $questionsTable->getAlias();
                $this->set($tableAlias, $this->paginate($questionsQuery));
                $this->set('tableAlias', $tableAlias);
                $this->set('_serialize', [$tableAlias, 'tableAlias']);
            }

            $supportTable = TableRegistry::get('AdminLTE.Messages');
            $supportEntity = $supportTable->newEntity();
            $this->set(compact('supportEntity', 'message', 'messageFromUser', 'replies'));
        }

        $this->set('messageId', $id);
        $this->set('title', 'View Ticket');
    }

    public function reply($id) {

        if($this->request->getMethod() == 'POST') {

            $data = $this->request->getData();

            $message = $data['message'];

            $messagesTable = TableRegistry::get('AdminLTE.Messages');
            $messagesQuery = $messagesTable->find('all')->where(['messages.id' => $id])->limit(1);
            $messageResult = $messagesQuery->first();

            $contactTable = TableRegistry::get('AdminLTE.Messages');
            $contactEntity = $contactTable->newEntity([
                'user_id'  => $this->Auth->user('id'),
                'subject'  => 'RE: ' . $messageResult->subject,
                'message'  => $message,
                'closed'   => 0,
                'topic'    => $messageResult->topic,
                'priority' => $messageResult->priority,
                'message_id' => $messageResult->id,
                'created'  => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);

            if($messageResult->message_id > 0) {

                $contactEntity->set('message_id', $messageResult->message_id);
                $opMessage = $messagesTable->get($messageResult->message_id);
            }
            else {

                $opMessage = $messagesTable->get($messageResult->id);
            }
            $result = $contactTable->save($contactEntity);

            $opMessage->modified = new \DateTime('now');
            $messagesTable->save($opMessage);

            if($messageResult->message_id > 0) {

                $this->redirect('/support/view/' . $messageResult->message_id);
            }
            else {

                $this->redirect($this->referer() . '#reply-' . $result->id);
            }
        }
        else {

            $this->Flash->error('You are not authrozied.');
            $this->redirect('/dashboard');
        }
    }

    public function close($id)
    {
        if($this->request->getMethod() == 'POST') {

            $usersTable = TableRegistry::get(Configure::read('Users.table'));
            $query = $usersTable->find('all')->where(['users.id' => $this->Auth->user('id')])->limit(1);
            $user = $query->first();

            $messagesTable = TableRegistry::get('AdminLTE.Messages');
            $opMessage = $messagesTable->get($id);

            $closeOpMessage = 0;

            if ($user->role == 'admin') {

                $closeOpMessage = 1;
            } else {

                if ($opMessage->user_id == $this->Auth->user('id')) {

                    $closeOpMessage = 1;
                }
            }

            if ($closeOpMessage == 1) {

                $opMessage->closed = $closeOpMessage;
                $messagesTable->save($opMessage);

                $this->Flash->success('Ticket Successfully Closed.');
            } else {

                $this->Flash->error('Could not close ticket... $closeOpMessage = 0');
            }

        }
        else {

            $this->Flash->error('Unknown Error, Invalid getMethod');
        }

        $this->redirect('/tickets');
    }

    public function tickets()
    {
        $usersTable = TableRegistry::get(Configure::read('Users.table'));
        $query = $usersTable->find('all')->where(['users.id' => $this->Auth->user('id')])->limit(1);
        $user = $query->first();

        $table = TableRegistry::get('AdminLTE.Messages');

        if($user->role == 'admin') {

            $messagesQuery = $table->find('all', ['contain' => ['FaqTopics']])->where(['messages.message_id' => 0, 'messages.closed' => 0]);
        }
        else {

            $messagesQuery = $table->find('all', ['contain' => ['FaqTopics']])->where(['messages.message_id' => 0, 'messages.closed' => 0, 'messages.user_id' => $user->id]);
        }

        $tableAlias = $table->getAlias();
        $this->set($tableAlias, $this->paginate($messagesQuery));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
        $this->set('title', 'View Open Tickets');
    }

    public function support()
    {
        $formSubmitted = false;

        if($this->request->getMethod() == 'POST') {

            $formSubmitted = true;

            $data = $this->request->getData();

            $subject = $data['subject'];
            $message = $data['message'];
            $topicId = $data['topic'];
            $priority = $data['priority'];

            $usersTable = TableRegistry::get(Configure::read('Users.table'));
            // $query = $usersTable->find('all')->where(['users.id' => $this->Auth->user('id')])->limit(1);
            // $user = $query->first();

            // $user_id = $user->get('id');
            $user_id = $this->Auth->user('id');

            $contactTable = TableRegistry::get('AdminLTE.Messages');
            $contactEntity = $contactTable->newEntity([
                'user_id'  => $user_id,
                'subject'  => $subject,
                'message'  => $message,
                'closed'   => 0,
                'topic'    => $topicId,
                'priority' => $priority,
                'created'  => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);
            $result = $contactTable->save($contactEntity);

            $message_id = $result->id;

            $support_username = 'admin'; // Configure::read('Users.support_username');

            $query = $usersTable->find('all')->where(['users.username' => $support_username])->limit(1);
            $admin = $query->first();

            $recipientsTable = TableRegistry::get('AdminLTE.Recipients');
            $recipientsEntity = $recipientsTable->newEntity([
                'message_id'  => $message_id,
                'user_id'     => $admin->get('id'),
                'created'     => new \DateTime('now'),
                'modified'    => new \DateTime('now')
            ]);
            $recipientsTable->save($recipientsEntity);

            $this->Flash->success('Support Ticket Created Successfully, We will be in touch shortly...');
            $this->redirect('/tickets');
        }

        $topicsTable = TableRegistry::get('AdminLTE.FaqTopics');
        $topicsQuery = $topicsTable->find('all');
        $topics = $topicsQuery->find('list');

        $supportTable = TableRegistry::get('AdminLTE.Messages');
        $supportEntity = $supportTable->newEntity();

        $this->set('topics', $topics);
        $this->set(compact('supportEntity', 'formSubmitted'));
        $this->set('title', 'Create Support Ticket');
    }

    public function contact()
    {
        $formSubmitted = false;

        if($this->request->getMethod() == 'POST') {

            $formSubmitted = true;

            // Array ( [email] => Jeffrey.l.roberts@gmail.com [subject] => asdgfasdg [message] => asdgffasdgdsfg )
            $data = $this->request->getData();

            $email = $data['email'];
            $subject = $data['subject'];
            $message = $data['message'];
            $user_id = 0;

            $usersTable = TableRegistry::get(Configure::read('Users.table'));
            $query = $usersTable->find('all')->where(['Users.email' => $email])->limit(1);
            $user = $query->first();

            if(!$user) {

                $username = explode('@', $email);
                $username = $username[0];
                $password = Generator::alphanumeric(8);

                $user = [
                    'id' => Text::uuid(),
                    'username' => $username,
                    'email' => $email,
                    'is_superuser' => '0',
                    'role' => 'user',
                    'active' => 1,
                    'created' => new \DateTime('now'),
                    'modified' => new \DateTime('now')
                ];

                $user = $usersTable->newEntity($user);
                $hashedPassword = $user->hashPassword($password);
                $user->set('password', $hashedPassword);
                $userResult = $usersTable->save($user);

                $user_id = $userResult->id;
            }
            else {

                $user_id = $user->id;
            }

            if($user_id > 0) {

                $user_id = $user->get('id');
                $contactTable = TableRegistry::get('AdminLTE.Messages');
                $contactEntity = $contactTable->newEntity([
                    'user_id' => $user_id,
                    'subject' => $subject,
                    'message' => $message,
                    'closed'  => 0,
                    'created' => new \DateTime('now'),
                    'modified' => new \DateTime('now')
                ]);
                $result = $contactTable->save($contactEntity);

                $message_id = $result->id;

                $support_username = 'superadmin'; // Configure::read('Users.support_username');

                $query = $usersTable->find('all')->where(['users.username' => $support_username])->limit(1);
                $admin = $query->first();

                $recipientsTable = TableRegistry::get('AdminLTE.Recipients');
                $recipientsEntity = $recipientsTable->newEntity([
                    'message_id' => $message_id,
                    'user_id' => $admin->get('id'),
                    'created' => new \DateTime('now'),
                    'modified' => new \DateTime('now')
                ]);
                $recipientsTable->save($recipientsEntity);

                $this->Flash->success('Contact Message Successfully Sent... Thank You, We will be in touch shortly...');
            }
            else {

                $this->Flash->error('Invalid User ID');
            }
            // @todo send email to user confirming contact message sent...
        }

        $contactTable = TableRegistry::get('AdminLTE.Messages');
        $contactEntity = $contactTable->newEntity();
        $this->set(compact('contactEntity', 'formSubmitted'));
        $this->set('title', 'Contact Us');
    }

    public function sendticket($id = 0)
    {
        $faqAnswersTable = TableRegistry::get('AdminLTE.faq_answers');
        $faqAnswersQuery = $faqAnswersTable->find('all')->where(['id' => $id])->limit(1);
        $faqAnswerEntity = $faqAnswersQuery->first();

        $messagesTable = TableRegistry::get('AdminLTE.Messages');
        $messagesQuery = $messagesTable->find('all')->where(['messages.id' => $this->request->getQuery('redirect')])->limit(1);
        $messageResult = $messagesQuery->first();

        $contactTable = TableRegistry::get('AdminLTE.Messages');
        $contactEntity = $contactTable->newEntity([
            'user_id'  => $this->Auth->user('id'),
            'subject'  => 'RE: ' . $messageResult->subject,
            'message'  => $faqAnswerEntity->answer,
            'closed'   => 0,
            'topic'    => $messageResult->topic,
            'priority' => $messageResult->priority,
            'message_id' => $messageResult->id,
            'created'  => new \DateTime('now'),
            'modified' => new \DateTime('now')
        ]);

        if($messageResult->message_id > 0) {

            $contactEntity->set('message_id', $messageResult->message_id);
            $opMessage = $messagesTable->get($messageResult->message_id);
        }
        else {

            $opMessage = $messagesTable->get($messageResult->id);
        }
        $result = $contactTable->save($contactEntity);

        $opMessage->modified = new \DateTime('now');
        $messagesTable->save($opMessage);

        $this->redirect('/support/view/' . $this->request->getQuery('redirect') . '?search=' . $this->request->getQuery('search'));
    }
}
