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

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use App\Model\Entity\SearchUsers;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SearchController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function users()
    {
        if($this->request->getMethod() == 'POST') {

            $data = $this->request->getData();

            $usersTable = TableRegistry::get(Configure::read('Users.table'));

            switch($data['field']) {

                case 'email':
                    $usersQueryVar = 'email';
                    break;
                case 'username':
                    $usersQueryVar = 'username';
                    break;
                case 'first_name':
                    $usersQueryVar = 'first_name';
                    break;
                case 'last_name':
                    $usersQueryVar = 'last_name';
                    break;
                case 'role':
                    $usersQueryVar = 'role';
                    break;
                default:
                    $usersQueryVar = 'email';
                    break;
            }

            $usersQuery = $usersTable->find('all')->where(['myusers.' . $usersQueryVar => $data['search']]);
            $usersResults = $usersQuery->count();

            $tableAlias = $usersTable->getAlias();
            $this->set($tableAlias, $this->paginate($usersQuery));
            $this->set('tableAlias', $tableAlias);
            $this->set('_serialize', [$tableAlias, 'tableAlias']);

            $this->set(compact('usersResults'));
        }
    }
}
