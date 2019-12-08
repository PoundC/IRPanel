<?php
namespace IRPanelJams\Controller;

use IRPanelJams\Controller\AppController;

/**
 * Jams Controller
 *
 *
 * @method \IRPanelJams\Model\Entity\Jam[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JamsController extends AppController
{
    public $paginate = [
        'limit' => 5,
        'order' => [
            'IRCJams.id' => 'desc'
        ]
    ];

    public function dashboard()
    {

    }

    public function player()
    {
        $this->loadModel('IRPanelJams.IRCJamsQueue');

        $jams = $this->paginate($this->IRCJamsQueue->find('all', ['contain' => ['IRCUsers', 'IRCJams']])->where(['played' => 'no']));

        $this->set(compact('jams'));
    }

    public function ajaxPlayer($id = 0)
    {
        $this->loadComponent('RequestHandler');

        $this->loadModel('IRPanelJams.IRCJamsQueue');

        $jams = $this->paginate($this->IRCJamsQueue->find('all', ['contain' => ['IRCUsers', 'IRCJams']])->where(['IRCJamsQueue.id >' => $id, 'played' => 'no']));

        $this->set('jams', $jams);
        $this->set('_serialize', ['jams']);

        $this->RequestHandler->renderAs($this, 'json');
    }

    public function ajaxPlayed($id = 0)
    {
        $this->loadComponent('RequestHandler');

        $this->loadModel('IRPanelJams.IRCJamsQueue');

        $jam = $this->IRCJamsQueue->find('all', ['contain' => ['IRCUsers', 'IRCJams']])->where(['IRCJams.link LIKE' => '%' . $id . '%'])->first();
        $jam->played = 'yes';
        $jam->playedts = new \DateTime();
        $this->IRCJamsQueue->save($jam);

        $this->set('jam', $jam);
        $this->set('_serialize', ['jam']);

        $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function history()
    {
        $this->loadModel('IRPanelJams.IRCJams');

        $jams = $this->paginate($this->IRCJams->find('all', ['contain' => ['IRCUsers']]));

        $this->set(compact('jams'));
    }

    public function search()
    {
        $this->loadModel('IRPanelJams.IRCJams');

        if($this->request->getMethod() == 'POST') {

            $search = $this->request->getData('search');

            $searchResults = $this->paginate($this->IRCJams->find('all', ['contain' => ['IRCUsers']])->where([
                'OR' => [
                    ['title LIKE' => '%' . $search . '%'],
                    ['searchable LIKE' => '%' . $search . '%'],
                    ['description LIKE' => '%' . $search . '%'],
                    ['username LIKE' => '%' . $search . '%'],
                    ['link LIKE' => '%' . $search . '%']
                ]
            ]));

            $this->set('results', $searchResults);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Jam id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jam = $this->Jams->get($id);
        if ($this->Jams->delete($jam)) {
            $this->Flash->success(__('The jam has been deleted.'));
        } else {
            $this->Flash->error(__('The jam could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
