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

use AdminLTE\Utility\Messaging;
use AdminLTE\Utility\Notifications;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Controller\Component\AuthComponent;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use AdminLTE\Utility\Menu;
use AdminLTE\Utility\Sidebar;
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

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('CakeDC/Users.UsersAuth');

        $this->Auth->configShallow('loginRedirect', '/dashboard');
        $this->Auth->configShallow('logoutRedirect', '/login');
        $this->Auth->configShallow('loginAction', '/login');
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */

        $this->loadComponent('Security');
        $this->loadComponent('Csrf');

        $this->Auth->allow(['register', 'requestResetPassword', 'login']);
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
        $isMember = false;
        $isCurrentUser = false;
        $notLoggedIn = false;
        $menus = array();

        if(method_exists($this->Auth, 'user')) {

            if ($this->Auth->user('id')) {

                $this->set('totalMessageCount', Messaging::getTotalCount($this->Auth->user('id')));
                $this->set('navMessagesArray', Messaging::getNavMessages($this->Auth->user('id')));
                $this->set('totalNotificationsCount', Notifications::getTotalCount($this->Auth->user('id')));
                $this->set('navNotificationsArray', Notifications::getNavNotifications($this->Auth->user('id')));

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
                else if ($currentUser->role == 'admin') {

                    $isAdmin = true;
                }
                else if($currentUser->role == 'member') {

                    $isMember = true;
                }

                if($currentUser->role == 'member' || $currentUser->role == 'user') {

                    $supportMenu = array(
                        'type'  => 'group',
                        'group' => 'Support Menu',
                        'icon'  => 'fa-support',
                        'css'   => 'active non-active',
                        'menu' => [
                            'View Tickets'     => [
                                'path' => '/tickets',
                                'icon' => 'fa-folder-open'
                            ],
                            'Open Ticket'     => [
                                'path' => '/support',
                                'icon' => 'fa-magic'
                            ]
                        ]
                    );

                    //@todo: Database driven setting, turn live chat on and off via toggle button
                    $liveChat = 'on';

                    if($liveChat == 'on') {

                        $supportMenu['menu']['Live Chat'] = [
                            'path' => '/chat',
                            'icon' => 'fa-wechat'
                        ];
                    }

                    // ProTip: Reversing the array to get the order I want
                    //         It's a delicate balance of order and chaos.
                    //         I want live chat on top, if not Open Ticket
                    $supportMenu['menu'] = array_reverse($supportMenu['menu'], true);

                    Sidebar::addMenuGroup($supportMenu, $currentUser->role);
                }

                $menus = Sidebar::buildMenu($this->request->here, $currentUser->role);

                if ($currentId == $this->Auth->user('id')) {

                    $isCurrentUser = true;
                }

            } else {

                $notLoggedIn = true;

                $usersTable = TableRegistry::get(Configure::read('Users.table'));
                $currentUser = $usersTable->newEntity();

                $menus = Sidebar::buildMenu($this->request->here, 'visitor');

            }

            $this->set('menus', $menus);
            $this->set(compact('isMember', 'currentUser', 'isCurrentUser', 'isAdmin', 'isSuperUser', 'notLoggedIn'));
        }

        $this->set('_serialize', ['currentUser']);
        $this->set('avatarPlaceholder', Configure::read('Users.Avatar.placeholder'));

        $this->viewBuilder()->setLayout('AdminLTE.default');

        //$this->loadComponent('Security');
    }
}
