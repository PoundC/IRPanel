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

        $this->loadModel('AdminLTE.ChatOpenchats');
        $tableQuery = $this->ChatOpenchats->find('all', ['contain' => ['Users', 'ChatChatrooms']])->where(['ChatOpenchats.active >' => $dt->format('Y-m-d H:i:s'), 'ChatOpenchats.open' => '1']);

        $tableAlias = $this->ChatOpenchats->alias();

        $this->set($tableAlias, $this->paginate($tableQuery));
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
        $this->set('title', 'Open Live Chats');
    }

    public function online($id = '')
    {
        $assign = $this->request->getQuery('assign');

        if ($id == '') {

            $id = $this->Auth->user('id');
        }

        $this->loadModel('AdminLTE.Users');
        $userQuery = $this->Users->find('all')->where(['id' => $this->Auth->user('id')]);
        $userResult = $userQuery->first();

        $this->loadModel('AdminLTE.ChatChatrooms');
        $chatRoomsQuery = $this->ChatChatrooms->find('all')->where(['ChatChatrooms.name' => $id]);
        $chatRoomsResult = $chatRoomsQuery->first();

        $tz = 'America/New_York';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string

        if ($chatRoomsResult == '') {

            $chatRoomsEntity = $this->ChatChatrooms->newEntity([
                'name' => $id,
                'topic' => 'Welcome',
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);

            $chatRoomsResult = $this->ChatChatrooms->save($chatRoomsEntity);
        }

        $this->loadModel('AdminLTE.ChatOpenchats');
        $openChatsQuery = $this->ChatOpenchats->find('all', ['contains' => ['ChatChatrooms']])->where(['ChatOpenchats.chatroom_id' => $chatRoomsResult->id, 'ChatOpenchats.open' => 1]);
        $openChatsEntity = $openChatsQuery->first();

        if($openChatsEntity != null) {

            if($assign == 'true' && $userResult->get('role') == 'admin') {

                $openChatsEntity->set('user_id', $this->Auth->user('id'));
            }
            $openChatsEntity->set('open', 1);
            $openChatsEntity->set('active', $dt->format('Y-m-d H:i:s'));
            $this->ChatOpenchats->save($openChatsEntity);
        }
        else {

            if($assign == 'true' && $userResult->get('role') == 'admin') {

                $assigned_user_id = $this->Auth->user('id');
            }
            else {

                $assigned_user_id = '0';
            }

            $openChatsEntity = $this->ChatOpenchats->newEntity([
                'chatroom_id' => $chatRoomsResult->id,
                'open' => 1,
                'active' => $dt->format('Y-m-d H:i:s'),
                'user_id' => $assigned_user_id,
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);

            $this->ChatOpenchats->save($openChatsEntity);
        }

        $this->loadModel('AdminLTE.ChatChats');
        $chatsQuery = $this->ChatChats->find('all', ['contain' => ['Users', 'ChatChatrooms']])->where(['ChatChats.chatroom_id' => $chatRoomsResult->id])->orderAsc('ChatChats.id')->limit('100');
        $chatsResults = $chatsQuery->all();

        $chatsEntity = $this->ChatChats->newEntity();
        $lastChats = $this->ChatChats->newEntity();

        $roomId = $chatRoomsResult->name;

        $message_id = 0;
        foreach ($chatsResults as $itemKey => $itemArray) {

            $message_id = $itemArray->id;
        }

        $token = $this->request->getParam('_csrfToken');

        $searchResults = 0;
        $searchQuery = '';

        $this->loadModel('AdminLTE.FaqQuestions');
        $this->loadModel('AdminLTE.FaqAnswers');

        if($this->request->getMethod() == 'POST' || $this->request->getQuery('search') != '') {

            if($this->request->getMethod() == 'GET') {

                $data['search'] = $this->request->getQuery('search');
            }
            else {

                $data = $this->request->getData();
            }

            $questionsQuery = $this->FaqQuestions->find('all', ['contain' => ['FaqAnswers', 'FaqAnswers.FaqTopics']])
                ->where(['FaqTopics.topic LIKE' => '%' . $data['search'] . '%'])
                ->orWhere(['FaqQuestions.question LIKE' => '%' . $data['search'] . '%'])
                ->orWhere(['FaqAnswers.answer LIKE' => '%' . $data['search'] . '%']);

            $searchQuery = $data['search'];

            $searchResults = $questionsQuery->count();

            $tableAlias = $this->FaqQuestions->getAlias();
            $this->set($tableAlias, $this->paginate($questionsQuery));
            $this->set('tableAlias', $tableAlias);
            $this->set('_serialize', [$tableAlias, 'tableAlias']);
        }

        $helptab_id = 0;

        $this->loadModel('AdminLTE.ChatHelptabs');
        $helpTabsQuery = $this->ChatHelptabs->find('all', ['contain' => ['ChatChatrooms', 'FaqAnswers', 'FaqAnswers.FaqQuestions']])->where(['ChatHelptabs.chatroom_id' => $chatRoomsResult->id, 'ChatHelptabs.id > ' . $helptab_id]);
        $helpTabsEntity = $helpTabsQuery->all();
        $helpTabsCount = $helpTabsQuery->count();
        $helpTabsAlias = $this->ChatHelptabs->getAlias();
        $this->set($helpTabsAlias, $this->paginate($helpTabsQuery));
        $this->set('helpTableAlias', $helpTabsAlias);

        foreach($helpTabsEntity as $helpTab) {

            $helptab_id = $helpTab->id;
        }

        $this->set('title', 'Live Chat Support');
        $this->set(compact('helpTabsEntity', 'helpTabsCount', 'helptab_id', 'searchQuery', 'searchResults', 'chatsResults', 'chatRoomsResult', 'chatsEntity', 'roomId', 'token', 'message_id', 'lastChats'));
    }

    public function chatsend($id = '')
    {
        $this->viewBuilder()->autoLayout(false);

        if ($this->request->getMethod() == 'POST') {

            $data = $this->request->getData();

            $this->loadModel('AdminLTE.ChatChatrooms');

            $chatRoomsQuery = $this->ChatChatrooms->find('all')->where(['ChatChatrooms.name' => $id]);
            $chatRoomsResult = $chatRoomsQuery->first();

            $this->loadModel('AdminLTE.ChatChats');

            $chatsEntity = $this->ChatChats->newEntity([
                'chatroom_id' => $chatRoomsResult->id,
                'user_id' => $this->Auth->user('id'),
                'message' => $data['message'],
                'created' => new \DateTime('now')
            ]);

            $chatsResult = $this->ChatChats->save($chatsEntity);

            $message_id = $chatsResult->id;

            $chatsEntity = $this->ChatChats->newEntity();
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


            $this->loadModel('AdminLTE.ChatChatrooms');
            $chatRoomsQuery = $this->ChatChatrooms->find('all')->where(['ChatChatrooms.name' => $id]);
            $chatRoomsResult = $chatRoomsQuery->first();

            $tz = 'America/New_York';
            $timestamp = time();
            $dt = new DateTime("now", new DateTimeZone($tz));

            $this->loadModel('AdminLTE.ChatOpenchats');

            $openChatsQuery = $this->ChatOpenchats->find('all', ['contain' => ['ChatChatrooms']])->where(['ChatOpenchats.chatroom_id' => $chatRoomsResult->id, 'ChatOpenchats.open' => 1]);
            $openChatsEntity = $openChatsQuery->first();

            if($this->Auth->user('id') != $openChatsEntity->get('user_id')) {

                $openChatsEntity->set('active', $dt->format('Y-m-d H:i:s'));
                $this->ChatOpenchats->save($openChatsEntity);
            }

            $this->loadModel('AdminLTE.ChatChats');

            $lastChatQuery = $this->ChatChats->find('all', ['contain' => ['Users']])->where(['ChatChats.chatroom_id' => $chatRoomsResult->id, 'ChatChats.id >' => $data['message_id']])->orderAsc('ChatChats.id');
            $lastChats = $lastChatQuery->all();

            if($lastChats != '') {

                foreach ($lastChats as $itemKey => $itemArray) {

                    $message_id = $itemArray->id;
                }
            }
            else {

                $lastChats = $this->ChatChats->newEntity();
            }

            $chatsEntity = $this->ChatChats->newEntity();

            $roomId = $id;

            $this->loadModel('AdminLTE.ChatHelptabs');

            $helpTabsQuery = $this->ChatHelptabs->find('all', ['contain' => ['ChatChatrooms', 'FaqAnswers']])->where(['ChatHelptabs.chatroom_id' => $chatRoomsResult->id, 'ChatHelptabs.id > ' . $helptab_id]);
            $helpTabsEntity = $helpTabsQuery->all();

            foreach($helpTabsEntity as $helpTab) {

                $helptab_id = $helpTab->id;
            }

            $this->set(compact('chatsEntity', 'helpTabsEntity', 'roomId', 'message_id', 'helptab_id', 'lastChats'));
        }

        $this->render('receive');
    }
}
