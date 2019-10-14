<?php
namespace AdminLTE\Controller;

use AdminLTE\Controller\AppController;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 *
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
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

            foreach($data as $message_id) {

                $message = $this->Messages->find('all')->where([
                    'Messages.account_id' => $this->Auth->user('id'),
                    'Messages.id' => $message_id
                ])->first();

                if (isset($message)) {

                    $message->set('user_deleted', 1);
                    $this->Messages->save($message);
                }
                else {

                    $message = $this->Messages->find('all')->where([
                        'Messages.to_user_id' => $this->Auth->user('id'),
                        'Messages.id' => $message_id
                    ])->first();

                    if (isset($message)) {

                        $message->set('recipient_deleted', 1);
                        $this->Messages->save($message);
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

        $notifications = $this->paginate($this->Notifications->find('all', ['contain' => ['Users']])->where([
            'Notifications.user_id' => $this->Auth->user('id'),
            'Notifications.deleted' => '0'
        ])->orderDesc('Notifications.created'));

        foreach($notifications as $notification) {

            $notification->set('seen', 1);

            $this->Notifications->save($notification);
        }

        $this->set(compact('notifications', 'checkAll'));
    }

    /**
     * View method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('notification', $notification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notification = $this->Notifications->newEntity();
        if ($this->request->is('post')) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $accounts = $this->Notifications->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $accounts = $this->Notifications->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('The notification has been deleted.'));
        } else {
            $this->Flash->error(__('The notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
