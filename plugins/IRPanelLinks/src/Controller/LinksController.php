<?php
namespace IRPanelLinks\Controller;

use IRPanelLinks\Controller\AppController;

/**
 * Links Controller
 *
 *
 * @method \IRPanelLinks\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LinksController extends AppController
{
    public $paginate = [
        'limit' => 15,
        'order' => [
            'IRCLinks.id' => 'desc'
        ]
    ];

    public function dashboard()
    {

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function browse()
    {
        $this->loadModel('IRPanelLinks.IRCLinks');

        $broswe = $this->IRCLinks->find('all', ['contain' => ['IRCUsers', 'IRCChannels', 'ParentComments' => ['IRCUsers', 'ChildComments' => ['IRCUsers']]]]);

        $links = $this->paginate($broswe);

        $this->set(compact('links'));
    }

    public function search()
    {
        $this->loadModel('IRPanelLinks.IRCLinks');

        if($this->request->getMethod() == 'POST') {

            $search = $this->request->getData('search');

            $searchResults = $this->paginate($this->IRCLinks->find('all', ['contain' => ['IRCUsers', 'IRCChannels']])->where([
                'OR' => [
                    ['title LIKE' => '%' . $search . '%'],
                    ['searchable LIKE' => '%' . $search . '%'],
                    ['description LIKE' => '%' . $search . '%'],
                    ['username LIKE' => '%' . $search . '%']
                ]
            ]));

            $this->set('results', $searchResults);
        }
    }

    public function view($id)
    {
        if($id == null) {

            return $this->redirect('/i_r_c_links/links/browse');
        }

        $this->loadModel('IRPanelLinks.IRCLinks');

        $link = $this->IRCLinks->find('all', ['contain' => ['IRCUsers', 'IRCChannels']])->where(['IRCLinks.id' => $id])->first();

        $this->set('link', $link);
    }

    /**
     * Delete method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $link = $this->Links->get($id);
        if ($this->Links->delete($link)) {
            $this->Flash->success(__('The link has been deleted.'));
        } else {
            $this->Flash->error(__('The link could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
