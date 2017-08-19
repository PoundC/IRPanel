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
    public function getUserTable()
    {
        $usersTable = TableRegistry::get(Configure::read('Users.table'));

        return $usersTable;
    }

    public function getUserRoleById($id)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity->get('role');
    }

    public function findUserBySubscriptionId($id)
    {
        $usersTable = $this->getUserTable();

        $userQuery = $usersTable->find('all', ['contain' => ['users_subscriptions']])
            ->where(['users_subscriptions.subscription_id' => $id]);

        $userEntity = $userQuery->first();

        return $userEntity;
    }

    public function findSubscriptionIdByUserId($id)
    {
        $usersTable = $this->getUserTable();

        $userQuery = $usersTable->find('all', ['contain' => ['users_subscriptions']])
            ->where(['users_subscriptions.user_id' => $id])
            ->orderDesc('created');

        $userEntity = $userQuery->first();

        return $userEntity;
    }

    public function findAllUsersBy($column, $value)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.' . $column => $value]);
        $usersEntities = $usersQuery->all();

        return $usersEntities;
    }

    public function countAllUsersBy($column, $value)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.' . $column => $value]);
        $usersEntities = $usersQuery->count();

        return $usersEntities;
    }

    public function getUserObject($id)
    {
        $usersTable = $this->getUserTable();
        $usersQuery = $usersTable->find('all')->where(['users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }
}