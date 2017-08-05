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
use DateTime;
use DateTimeZone;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ChatController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['chatsend', 'receive', 'online']);
    }

    public function openchats()
    {
        $tz = 'America/New_York';
        $timestamp = time();
        $dt = new DateTime("15 minutes ago", new DateTimeZone($tz)); //first argument "must" be a string

        $table = TableRegistry::get('Openchats');
        $tableQuery = $table->find('all', ['contain' => ['Users', 'Chatrooms']])->where(['openchats.active >' => $dt->format('Y-m-d H:i:s'), 'openchats.open' => '1']);

        $tableAlias = $table->alias();

        $this->set($tableAlias, $this->paginate($tableQuery));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
    }

    public function online($id = '')
    {
        $assign = $this->request->getQuery('assign');

        if ($id == '') {

            $id = $this->Auth->user('id');
        }

        $userTable = TableRegistry::get('Users');
        $userQuery = $userTable->find('all')->where(['id' => $this->Auth->user('id')]);
        $userResult = $userQuery->first();

        $chatRoomsTable = TableRegistry::get('Chatrooms');
        $chatRoomsQuery = $chatRoomsTable->find('all')->where(['chatrooms.name' => $id]);
        $chatRoomsResult = $chatRoomsQuery->first();

        $tz = 'America/New_York';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string

        $openChatsTable = TableRegistry::get('Openchats');
        $openChatsQuery = $openChatsTable->find('all', ['contains' => ['Chatrooms']])->where(['openchats.chatroom_id' => $chatRoomsResult->id, 'openchats.open' => 1]);
        $openChatsEntity = $openChatsQuery->first();

        if ($chatRoomsResult == '') {

            $chatRoomsEntity = $chatRoomsTable->newEntity([
                'name' => $id,
                'topic' => 'Welcome',
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);

            $chatRoomsResult = $chatRoomsTable->save($chatRoomsEntity);
        }

        if($openChatsEntity != null) {

            if($assign == 'true' && $userResult->get('role') == 'admin') {

                $openChatsEntity->set('user_id', $this->Auth->user('id'));
            }
            $openChatsEntity->set('open', 1);
            $openChatsEntity->set('active', $dt->format('Y-m-d H:i:s'));
            $openChatsTable->save($openChatsEntity);
        }
        else {

            if($assign == 'true' && $userResult->get('role') == 'admin') {

                $assigned_user_id = $this->Auth->user('id');
            }
            else {

                $assigned_user_id = '0';
            }

            $openChatsEntity = $openChatsTable->newEntity([
                'chatroom_id' => $chatRoomsResult->id,
                'open' => 1,
                'active' => $dt->format('Y-m-d H:i:s'),
                'user_id' => $assigned_user_id,
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);

            $openChatsTable->save($openChatsEntity);
        }

        $chatsTable = TableRegistry::get('Chats');
        $chatsQuery = $chatsTable->find('all', ['contain' => ['Users', 'Chatrooms']])->where(['chats.chatroom_id' => $chatRoomsResult->id])->orderAsc('chats.id')->limit('100');
        $chatsResults = $chatsQuery->all();

        $chatsEntity = $chatsTable->newEntity();
        $lastChats = $chatsTable->newEntity();

        $roomId = $chatRoomsResult->name;

        foreach ($chatsResults as $itemKey => $itemArray) {

            $message_id = $itemArray->id;
        }

        $token = $this->request->getParam('_csrfToken');

        $searchResults = 0;
        $searchQuery = '';

        if($this->request->getMethod() == 'POST' || $this->request->getQuery('search') != '') {

            if($this->request->getMethod() == 'GET') {

                $data['search'] = $this->request->getQuery('search');
            }
            else {

                $data = $this->request->getData();
            }

            $questionsTable = TableRegistry::get('faq_questions');
            $questionsQuery = $questionsTable->find('all', ['contain' => ['faq_answers', 'faq_answers.faq_topics']])
                ->where(['faq_topics.topic LIKE' => '%' . $data['search'] . '%'])
                ->orWhere(['faq_questions.question LIKE' => '%' . $data['search'] . '%'])
                ->orWhere(['faq_answers.answer LIKE' => '%' . $data['search'] . '%']);

            $searchQuery = $data['search'];

            $searchResults = $questionsQuery->count();

            $tableAlias = $questionsTable->getAlias();
            $this->set($tableAlias, $this->paginate($questionsQuery));
            $this->set('tableAlias', $tableAlias);
            $this->set('_serialize', [$tableAlias, 'tableAlias']);
        }

        $helptab_id = 0;

        $helpTabsTable = TableRegistry::get('helptabs');
        $helpTabsQuery = $helpTabsTable->find('all', ['contain' => ['Chatrooms', 'Faq_Answers', 'Faq_Answers.Faq_Questions']])->where(['helptabs.chatroom_id' => $chatRoomsResult->id, 'helptabs.id > ' . $helptab_id]);
        $helpTabsEntity = $helpTabsQuery->all();
        $helpTabsCount = $helpTabsQuery->count();
        $helpTabsAlias = $helpTabsTable->getAlias();
        $this->set($helpTabsAlias, $this->paginate($helpTabsQuery));
        $this->set('helpTableAlias', $helpTabsAlias);



        foreach($helpTabsEntity as $helpTab) {

            $helptab_id = $helpTab->id;
        }

        $this->set(compact('helpTabsEntity', 'helpTabsCount', 'helptab_id', 'searchQuery', 'searchResults', 'chatsResults', 'chatRoomsResult', 'chatsEntity', 'roomId', 'token', 'message_id', 'lastChats'));
    }

    public function chatsend($id = '')
    {
        $this->viewBuilder()->autoLayout(false);

        if ($this->request->getMethod() == 'POST') {

            $data = $this->request->getData();

            $chatRoomsTable = TableRegistry::get('Chatrooms');
            $chatRoomsQuery = $chatRoomsTable->find('all')->where(['chatrooms.name' => $id]);
            $chatRoomsResult = $chatRoomsQuery->first();

            $chatsTable = TableRegistry::get('Chats');

            $chatsEntity = $chatsTable->newEntity([
                'chatroom_id' => $chatRoomsResult->id,
                'user_id' => $this->Auth->user('id'),
                'message' => $data['message'],
                'created' => new \DateTime('now')
            ]);

            $chatsResult = $chatsTable->save($chatsEntity);

            $message_id = $chatsResult->id;

            $chatsEntity = $chatsTable->newEntity();
            $chatsEntity->set('messagee', '');

            $roomId = $chatRoomsResult->name;

            $this->set(compact('chatsEntity', 'roomId', 'message_id'));
        }

        $this->render('chatsend');
    }

    public function receive($id)
    {
        $this->viewBuilder()->autoLayout(false);

        if ($this->request->getMethod() == 'POST') {

            $data = $this->request->getData();
            $message_id = $data['message_id'];
            $helptab_id = $data['helptab_id'];

            $chatRoomsTable = TableRegistry::get('Chatrooms');
            $chatRoomsQuery = $chatRoomsTable->find('all')->where(['chatrooms.name' => $id]);
            $chatRoomsResult = $chatRoomsQuery->first();

            $tz = 'America/New_York';
            $timestamp = time();
            $dt = new DateTime("now", new DateTimeZone($tz));

            $openChatsTable = TableRegistry::get('Openchats');
            $openChatsQuery = $openChatsTable->find('all', ['contain' => ['Chatrooms']])->where(['openchats.chatroom_id' => $chatRoomsResult->id, 'openchats.open' => 1]);
            $openChatsEntity = $openChatsQuery->first();

            if($this->Auth->user('id') != $openChatsEntity->get('user_id')) {

                $openChatsEntity->set('active', $dt->format('Y-m-d H:i:s'));
                $openChatsTable->save($openChatsEntity);
            }

            $chatsTable = TableRegistry::get('Chats');
            $lastChatQuery = $chatsTable->find('all', ['contain' => ['Users']])->where(['chats.chatroom_id' => $chatRoomsResult->id, 'chats.id >' => $data['message_id']])->orderAsc('chats.id');
            $lastChats = $lastChatQuery->all();

            if($lastChats != '') {

                foreach ($lastChats as $itemKey => $itemArray) {

                    $message_id = $itemArray->id;
                }
            }
            else {

                $lastChats = $chatsTable->newEntity();
            }

            $chatsEntity = $chatsTable->newEntity();

            $roomId = $id;

            $helpTabsTable = TableRegistry::get('helptabs');
            $helpTabsQuery = $helpTabsTable->find('all', ['contain' => ['Chatrooms', 'Faq_Answers']])->where(['helptabs.chatroom_id' => $chatRoomsResult->id, 'helptabs.id > ' . $helptab_id]);
            $helpTabsEntity = $helpTabsQuery->all();

            foreach($helpTabsEntity as $helpTab) {

                $helptab_id = $helpTab->id;
            }

            $this->set(compact('chatsEntity', 'helpTabsEntity', 'roomId', 'message_id', 'helptab_id', 'lastChats'));
        }

        $this->render('receive');
    }
}