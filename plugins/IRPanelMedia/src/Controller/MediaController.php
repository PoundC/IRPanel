<?php
namespace IRPanelMedia\Controller;

use IRPanelMedia\Controller\AppController;

/**
 * Media Controller
 *
 *
 * @method \IRPanelMedia\Model\Entity\Media[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MediaController extends AppController
{
    public $paginate = [
        'limit' => 5,
        'order' => [
            'IRCMedia.id' => 'desc'
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
        $this->loadModel('IRPanelMedia.IRCMedia');

        $media = $this->paginate($this->IRCMedia->find('all', ['contain' => ['IRCUsers', 'IRCMediaGalleries']]));

        $this->set(compact('media'));
    }

    public function search()
    {
        $this->loadModel('IRPanelMedia.IRCMedia');

        if($this->request->getMethod() == 'POST') {

            $search = $this->request->getData('search');

            $searchResults = $this->paginate($this->IRCMedia->find('all', ['contain' => ['IRCUsers', 'IRCMediaGalleries']])->where([
                'OR' => [
                    ['title LIKE' => '%' . $search . '%'],
                    ['searchable LIKE' => '%' . $search . '%'],
                    ['description LIKE' => '%' . $search . '%'],
                    ['username LIKE' => '%' . $search . '%'],
                    ['media_type' =>  $search],
                    ['link LIKE' => '%' . $search . '%']
                ]
            ]));

            $this->set('results', $searchResults);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Media id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $media = $this->Media->get($id);
        if ($this->Media->delete($media)) {
            $this->Flash->success(__('The media has been deleted.'));
        } else {
            $this->Flash->error(__('The media could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
