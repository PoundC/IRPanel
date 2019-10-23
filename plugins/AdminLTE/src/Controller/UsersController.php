<?php

namespace AdminLTE\Controller;

use AdminLTE\Controller\Traits\ProfileTrait;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use CakeDC\Users\Controller\UsersController as BaseUsersController;
use Cake\Core\Configure;
use Firebase\JWT\JWT;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use CakeDC\Users\Controller\Component\UsersAuthComponent;
use AdminLTE\Utility\Users;

class UsersController extends BaseUsersController
{
    use ProfileTrait;

    public function initialize() {

        parent::initialize();

        $this->Auth->allow('login', 'oauth2callback');
    }

    public function oauth2callback()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(__DIR__ . '/../../config/client_secrets.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback');
        $client->addScope(\Google_Service_Analytics::ANALYTICS_READONLY);

        if (!isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            $this->redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            $this->redirect(filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }

    public function changePassword()
    {
        $id = basename($this->request->here);

        $usersTable = TableRegistry::get(Configure::read('Users.table'));
        $query = $usersTable->find('all')->where(['id' => $id])->limit(1);
        $user2 = $query->first();

        $this->set(compact('user2'));

        $this->set('title', 'Change User Password');

        parent::changePassword();

        $this->render('admin_change_password');
    }

    public function edit($id = null)
    {
        if($this->Auth->user('id') != $id && $this->Auth->user('role') == 'user')
        {
            $this->Flash->error('You do not have permission to visit that page');

            return $this->redirect('/profile');
        }

        $table = $this->loadModel();
        $tableAlias = $table->getAlias();
        $entity = $table->get($id, [
            'contain' => []
        ]);
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->set('_serialize', [$tableAlias, 'tableAlias']);
        if (!$this->request->is(['patch', 'post', 'put'])) {
            return;
        }
        $entity = $table->patchEntity($entity, $this->request->getData());
        $singular = Inflector::singularize(Inflector::humanize($tableAlias));
        if ($table->save($entity)) {
            $this->Flash->success(__d('CakeDC/Users', 'The {0} has been saved', $singular));

            return $this->redirect('/profile');
        }
        $this->Flash->error(__d('CakeDC/Users', 'The {0} could not be saved', $singular));
    }

    public function register() {

        $this->eventManager()->on(UsersAuthComponent::EVENT_AFTER_REGISTER, function ($event) {
             $email = $event->subject->request->data['email'];
             $users = new Users();
             $user = $users->getUserByEmail($email);
             $users->update($user,'api_token', JWT::encode(
                 [
                     'sub' => $user->id,
                     'exp' =>  time() + 604800
                 ],
                 Security::salt()));
        });

        $this->set('title', 'Register User');

        parent::register();
    }

    public function login() {

        $this->set('title', 'PoundC Login');

        $this->viewBuilder()->setLayout('AdminLTE.stars');

        parent::login();
    }

    public function requestResetPassword() {

        $this->set('title', 'Reset Password');

        parent::requestResetPassword();
    }
}
