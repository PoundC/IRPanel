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
class ChatController extends AppController
{

    public function initialize()
    {

        parent::initialize();

        $this->Auth->allow(['chatsend', 'receive', 'online']);
    }

    public function online($id = '')
    {

        if ($id == '') {

            $id = $this->Auth->user('id');
        }

        $chatRoomsTable = TableRegistry::get('Chatrooms');
        $chatRoomsQuery = $chatRoomsTable->find('all')->where(['chatrooms.name' => $id]);
        $chatRoomsResult = $chatRoomsQuery->first();

        if ($chatRoomsResult == '') {

            $chatRoomsEntity = $chatRoomsTable->newEntity([
                'name' => $id,
                'topic' => 'Welcome',
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);

            $chatRoomsResult = $chatRoomsTable->save($chatRoomsEntity);
        }

        $chatsTable = TableRegistry::get('Chats');
        $chatsQuery = $chatsTable->find('all', ['contain' => ['Users', 'Chatrooms']])->where(['chats.room_id' => $chatRoomsResult->id])->orderAsc('chats.id')->limit('100');
        $chatsResults = $chatsQuery->all();

        $chatsEntity = $chatsTable->newEntity();
        $lastChats = $chatsTable->newEntity();

        $roomId = $chatRoomsResult->name;

        foreach ($chatsResults as $itemKey => $itemArray) {

            $message_id = $itemArray->id;
        }

        $token = $this->request->getParam('_csrfToken');

        $this->set(compact('chatsResults', 'chatRoomsResult', 'chatsEntity', 'roomId', 'token', 'message_id', 'lastChats'));
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
                'room_id' => $chatRoomsResult->id,
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

            $chatRoomsTable = TableRegistry::get('Chatrooms');
            $chatRoomsQuery = $chatRoomsTable->find('all')->where(['chatrooms.name' => $id]);
            $chatRoomsResult = $chatRoomsQuery->first();

            $chatsTable = TableRegistry::get('Chats');
            $lastChatQuery = $chatsTable->find('all')->where(['chats.room_id' => $chatRoomsResult->id, 'chats.id >' => $data['message_id']])->orderAsc('id');
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

            $this->set(compact('chatsEntity', 'roomId', 'message_id', 'lastChats'));
        }

        $this->render('receive');
    }
}