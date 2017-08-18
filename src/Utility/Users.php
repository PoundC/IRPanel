<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:35 AM
 */

namespace App\Utility;

use Cake\ORM\TableRegistry;

class Users
{
    public function getUserObject($id)
    {
        $usersTable = TableRegistry::get(Configure::read('Users.table'));
        $usersQuery = $usersTable->find('all')->where(['users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }
}