<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Controller\Component\AuthComponent;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\Utility\Menu;
use CakeDC\Users\Controller\Traits\CustomUsersTableTrait;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    use CustomUsersTableTrait;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('CakeDC/Users.UsersAuth');

        $this->Auth->configShallow('loginRedirect', '/dashboard');
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        // Note: These defaults are just to get started quickly with development
        // and should not be used in production. You should instead set "_serialize"
        // in each action as required.
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        $appContain = (array)Configure::read('Auth.authenticate.' . AuthComponent::ALL . '.contain');
        $socialContain = Configure::read('Users.Social.login') ? ['SocialAccounts']: [];

        $isSuperUser = false;
        $isAdmin = false;
        $isCurrentUser = false;
        $notLoggedIn = false;

        if(method_exists($this->Auth, 'user')) {
            if ($this->Auth->user('id')) {

                $currentId = $this->Auth->user('id');

                if (isset($this->request->params['pass'][0])) {

                    $currentId = $this->request->params['pass'][0];
                }

                $currentUser = TableRegistry::get(Configure::read('Users.table'))->get($this->Auth->user('id'), [
                    'contain' => array_merge((array)$appContain, (array)$socialContain)
                ]);

                if ($currentUser->is_superuser == 1) {

                    $isSuperUser = true;
                    $isAdmin = true;
                }

                if ($currentUser->role == 'admin') {

                    $isAdmin = true;
                }

                if ($currentId == $this->Auth->user('id')) {

                    $isCurrentUser = true;
                }

                $this->set('menus', Menu::getUserMenu($this->request->here));
                $this->set(compact('currentUser', 'isCurrentUser', 'isAdmin', 'isSuperUser', 'notLoggedIn'));

            } else {

                $notLoggedIn = true;

                $currentUser = $this->getUsersTable()->newEntity();

                $this->set('menus', Menu::getVisitorMenu($this->request->here));
                $this->set(compact('currentUser', 'isCurrentUser', 'isAdmin', 'isSuperUser', 'notLoggedIn'));
            }
        }

        $this->set('_serialize', ['currentUser']);
        $this->set('avatarPlaceholder', Configure::read('Users.Avatar.placeholder'));


    }
}
