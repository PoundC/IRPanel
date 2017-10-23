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
use Cake\View\Exception\MissingTemplateException;
use App\Utility\Users;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class MembersController extends AppController
{
    public function initialize() {

        parent::initialize();

        //$this->Auth->allow(['dashboard']);
    }

    /**
     *
     */
    public function dashboard()
    {
        $users = new Users();
        $user = $users->getUserById($this->Auth->user('id'));

        switch($user->get('role'))
        {
            case 'admin':
                $this->dashboard_admin($user);
                break;
        }

        $this->set('title', 'Dashboard');
    }

    /**
     * @param $user
     */
    private function dashboard_admin($user)
    {
        // New Users
        // New Members
        // New Support Chats
        // New Support Tickets
    }
}