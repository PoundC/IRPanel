<?php
namespace AdminLTE\Controller;

use AdminLTE\Controller\AppController;
use AdminLTE\Utility\Tasks;

/**
 * AdminLTETasks Controller
 *
 *
 * @method \AdminLTE\Model\Entity\AdminLTETask[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->loadModel('AdminLTETasks');

        $adminLTETasks = $this->paginate($this->AdminLTETasks->find('all')->where([
            'user_id' => $this->Auth->user('id'),
            'completed' => 0
        ]));

        $this->AdminLTETasks->updateAll(['seen' => 1], ['user_id' => $this->Auth->user('id'), 'seen' => 0]);

        $this->set(compact('adminLTETasks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin L T E Task id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['get']);
        $this->loadModel('AdminLTETasks');
        $adminLTETask = $this->AdminLTETasks->get($id);
        if($adminLTETask->user_id == $this->Auth->user('id')) {
            Tasks::markPendingTaskDeleted($adminLTETask->id);
        }

        $this->viewBuilder()->layout('AdminLTE.blank');
    }
}
