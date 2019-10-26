<?php
namespace AdminLTE\Controller;

use AdminLTE\Controller\AppController;
use AdminLTE\Utility\Janitor;
use AdminLTE\Utility\MenuNotifications;
use AdminLTE\Utility\Messaging;
use AdminLTE\Utility\Notifications;
use AdminLTE\Utility\Tasks;

/**
 * Messaging Controller
 *
 *
 * @method \App\Model\Entity\Message[] paginate($object = null, array $settings = [])
 */
class MessagingController extends AppController
{

    public function initialize() {

        parent::initialize();

        $this->viewBuilder()->setLayout('AdminLTE.default');
    }

    public function messageDelete($id = null)
    {
        if ($this->request->getMethod() == 'POST')
        {
            $message = $this->Messaging->find('all')->where([
                'Messaging.user_id' => $this->Auth->user('id'),
                'Messaging.id' => $id
            ])->first();

            if(isset($message)) {

                $message->set('user_deleted', 1);
                $this->Messaging->save($message);
            }
            else {

                $message = $this->Messaging->find('all')->where([
                    'Messaging.to_user_id' => $this->Auth->user('id'),
                    'Messaging.id' => $id
                ])->first();

                if (isset($message)) {

                    $message->set('recipient_deleted', 1);
                    $this->Messaging->save($message);
                }
            }
        }

        return $this->redirect('/messages?inbox=user');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->request->getMethod() == 'POST' && $this->request->getData('submit') == 'deleteChecked') {

            $data = $this->request->getData('checkie');

            foreach($data as $key => $messaging_id) {

                $message = $this->Messaging->find('all')->where([
                    'Messaging.user_id' => $this->Auth->user('id'),
                    'Messaging.id' => $messaging_id
                ])->first();

                if (isset($message)) {

                    $message->set('user_deleted', 1);
                    $this->Messaging->save($message);
                }
                else {

                    $message = $this->Messaging->find('all')->where([
                        'Messaging.to_user_id' => $this->Auth->user('id'),
                        'Messaging.id' => $messaging_id
                    ])->first();

                    if (isset($message)) {

                        $message->set('recipient_deleted', 1);
                        $this->Messaging->save($message);
                    }
                }
            }
        }

        if($this->request->getMethod() == 'POST' && $this->request->getData('submit') == 'checkAll') {

            $checkAll = true;
        }
        else {

            $checkAll = false;
        }

        if($this->request->getQuery('inbox') == '' || $this->request->getQuery('inbox') == 'user') {
            $messages = $this->paginate($this->Messaging->find('all', ['contain' => ['Users', 'Recipients']])
//                ->where([
//                'Messaging.user_id' => $this->Auth->user('id'),
//                'Messaging.user_deleted' => 0
//            ])
                ->where([
                'Messaging.to_user_id' => $this->Auth->user('id'),
                'Messaging.recipient_deleted' => 0
            ])->orderDesc('Messaging.created'));

            $sentActive = '';
            $userActive = 'active';
            $deletedActive = '';
            $inboxTitle = 'User Inbox';

            $url = '/messages?inbox=user';
        }
        else if($this->request->getQuery('inbox') == 'sent') {
            $messages = $this->paginate($this->Messaging->find('all', ['contain' => ['Users', 'Recipients']])->where([
                'Messaging.user_id' => $this->Auth->user('id'),
                'Messaging.user_deleted' => 0
            ])->orderDesc('Messaging.created'));

            $sentActive = 'active';
            $userActive = '';
            $deletedActive = '';
            $inboxTitle = 'Sent Box';

            $url = '/messages?inbox=sent';
        }
        else if($this->request->getQuery('inbox') == 'deleted') {
            $messages = $this->paginate($this->Messaging->find('all', ['contain' => ['Users', 'Recipients']])->where([
                'Messaging.user_id' => $this->Auth->user('id'),
                'Messaging.user_deleted' => 1
            ])->orWhere([
                'Messaging.to_user_id' => $this->Auth->user('id'),
                'Messaging.recipient_deleted' => 1
            ])->orderDesc('Messaging.created'));

            $sentActive = '';
            $userActive = '';
            $deletedActive = 'active';
            $inboxTitle = 'Deleted Box';

            $url = '/messages?inbox=deleted';
        }
        $userCount = Messaging::getUserCount($this->Auth->user('id'));

        MenuNotifications::markMenuNotificationsSeen($this->Auth->user('id'), $this->Auth->user('role'), 'Messages', 'Messages');

        $this->set('role', $this->Auth->user('role'));
        $this->set('user_id', $this->Auth->user('id'));
        $this->set(compact('messages', 'userActive', 'sentActive', 'userCount'));
        $this->set(compact('inboxTitle', 'url', 'checkAll', 'deletedActive'));
        $this->set('_serialize', ['messages']);
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Messaging->find('all', ['contain' => ['Users', 'Recipients']])->where([
            'Messaging.id' => $id,
            'Messaging.user_id' => $this->Auth->user('id')
        ])->orWhere([
            'Messaging.id' => $id,
            'Messaging.to_user_id' => $this->Auth->user('id')
        ])->first();

        if(!isset($message)) {

            Janitor::hackAttempt();
        }

        /*
        if($message->get('user_id') == $this->Auth->user('id')) {

            $connection = $this->Messaging->getConnection();
            $message->set($connection->quoteIdentifier('read'), 1);
        }
        else */

        if($message->get('to_user_id') == $this->Auth->user('id')) {

            $message->set('recipient_read', 1);
            $this->Messaging->save($message);
        }

        $sentActive = '';
        $userActive = '';
        $deletedActive = '';

        $userCount = Messaging::getUserCount($this->Auth->user('id'));

        $this->set(compact('userCount','userActive', 'sentActive', 'deletedActive'));
        $this->set('userCount', $userCount);
        $this->set('username', $this->Auth->user('username'));
        $this->set('role', $this->Auth->user('role'));
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('message', $message);
        $this->set('_serialize', ['message']);
    }

    public function compose() {

        if($this->request->getMethod() == 'POST') {

            $subject = $this->request->getData('subject');
            $body = $this->request->getData('message');
            $to_user_id = $this->request->getData('to-hidden');

            if($to_user_id == '') {

                $to_user = \AdminLTE\Utility\Users::getUserByUsername($this->request->getData('to'));
                $to_user_id = $to_user->id;
            }

            $message = $this->Messaging->newEntity([
                'messaging_id' => 0,
                'subject' => $subject,
                'message' => $body,
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now'),
                'user_id' => $this->Auth->user('id'),
                'to_user_id' => $to_user_id,
                'messaging.read' => 1
            ]);

            $this->Messaging->save($message);

            MenuNotifications::addUserItemMenuNotification($to_user_id, 'Messages', 'Messages');

            Notifications::addUserNotificationsEntry($to_user_id, Notifications::Message, $this->Auth->user('first_name') . ' sent you a message', 'Success','/messages/' . $message->id);

            Tasks::addPendingTask($to_user_id, 'You Received a Message', 'Please respond to this message.', '/messasge/' . $message->id, 'fa fa-envelope', Tasks::Info, 'Send Reply');

            $this->Flash->success('Your Message Was Sent Successfully');

            return $this->redirect('/messages?inbox=sent');
        }

        $sentActive = '';
        $userActive = '';
        $deletedActive = '';

        $userCount = Messaging::getUserCount($this->Auth->user('id'));

        $this->set(compact('userCount','userActive', 'sentActive', 'deletedActive'));
    }

    public function toAutocomplete() {

        $this->loadModel('Users');
        $term = $this->request->getQuery('term');
        $autocomplete = $this->Users->find('all', ['fields' => ['first_name','last_name','id']])
            ->where(['first_name LIKE' => $term . '%'])
            ->orWhere(['last_name LIKE' => $term . '%'])->limit(10)->all();

        $response = array();
        foreach($autocomplete as $acomplete) {
            $response[] = [
                'value' => $acomplete->get('first_name') . ' ' . $acomplete->get('last_name'),
                'id' => $acomplete->get('id')
            ];
        }

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function sendReply($id = null)
    {
        if($this->request->getMethod() == 'POST') {
            $message = $this->Messaging->find('all', ['contain' => ['Users', 'Recipients']])->where([
                'Messaging.id' => $id,
                'Messaging.user_id' => $this->Auth->user('id')
            ])->orWhere([
                'Messaging.id' => $id,
                'Messaging.to_user_id' => $this->Auth->user('id')
            ])->first();

            if (!isset($message)) {

                Janitor::hackAttempt();
            }

            if ($message->get('user_id') == $this->Auth->user('id')) {

                $to_user_id = $message->get('to_user_id');
                //$message->set('read', 0);
                //$message->set('modified', new \DateTime('now'));
            } else if ($message->get('to_user_id') == $this->Auth->user('id')) {

                $to_user_id = $message->get('user_id');
                //$message->set('recipient_read', 0);
                $message->set('modified', new \DateTime('now'));
                $message->set('replied', 1);
            }

            $this->Messaging->save($message);

            $body = $this->request->getData('reply_field');

            $subject = $message->get('subject');
            if(substr($subject, 0, 3) != 'RE:') {
                $subject = 'RE: ' . $subject;
            }

            $reply = $this->Messaging->newEntity([
                'messaging_id' => $message->id,
                'subject' => $subject,
                'message' => $body,
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now'),
                'user_id' => $this->Auth->user('id'),
                'to_user_id' => $to_user_id,
                'messaging.read' => 1
            ]);

            MenuNotifications::addUserItemMenuNotification($to_user_id, 'Messages', 'Messages');

            $this->Messaging->save($reply);

            $this->Flash->success('Your Message Was Sent Successfully');

            return $this->redirect('/messages?inbox=user');
        }
        else {

            Janitor::hackAttempt();
        }
    }
}
