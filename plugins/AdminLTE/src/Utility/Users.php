<?php
/**
 * Created by PhpStorm.
 * User: jlroberts
 * Date: 8/18/17
 * Time: 11:35 AM
 */

namespace AdminLTE\Utility;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class Users
{
    public static function getUserTable()
    {
        $usersTable = TableRegistry::get(Configure::read('Users.table'));

        return $usersTable;
    }

    public static function update($user, $column, $value)
    {
        $usersTable = Users::getUserTable();
        $user->set($column, $value);
        $usersTable->save($user);
    }

    public static function getUserById($id)
    {
        $usersTable = Users::getUserTable();
        $usersQuery = $usersTable->find('all')->where(['Users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }

    public static function getUserByEmail($email)
    {
        $usersTable = Users::getUserTable();
        $usersQuery = $usersTable->find('all')->where(['Users.email' => $email])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }

    public static function getUserByUsername($username)
    {
        $usersTable = Users::getUserTable();
        $usersQuery = $usersTable->find('all')->where(['Users.username' => $username])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }

    public static function getOtherUserByID($user_id)
    {
        $usersTable = self::getUserTable();

        $user = $usersTable->find('all')->where(['id' => $user_id])->first();

        return $user;
    }

    public static function getUserRoleById($id)
    {
        $usersTable = Users::getUserTable();
        $usersQuery = $usersTable->find('all')->where(['Users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity->get('role');
    }

    public static function findUserBySubscriptionId($id)
    {
        $subscriptionsTable = TableRegistry::get('users_subscriptions');
        $subscriptionQuery = $subscriptionsTable->find('all')->where(['subscription_id' => $id])->limit(1);
        $subscriptionEntity = $subscriptionQuery->first();

        $usersTable = Users::getUserTable();

        if(isset($subscriptionEntity)) {

            $userQuery = $usersTable->find('all')
                ->where(['id' => $subscriptionEntity->get('user_id')]);

            $userEntity = $userQuery->first();

            return $userEntity;
        }
        else {

            return null;
        }
    }

    public static function findSubscriptionIdByUserId($id)
    {
        $usersTable = Users::getUserTable();

        $subscriptionsTable = TableRegistry::get('users_subscriptions');
        $subscriptionQuery = $subscriptionsTable->find('all')->where(['user_id' => $id])->orderDesc('ref_id')->limit(1);
        $subscriptionEntity = $subscriptionQuery->first();

        return $subscriptionEntity->get('subscription_id');
    }

    public static function findAllUsersBy($column, $value)
    {
        $usersTable = Users::getUserTable();
        $usersQuery = $usersTable->find('all')->where(['Users.' . $column => $value]);
        $usersEntities = $usersQuery->all();

        return $usersEntities;
    }

    public static function countAllUsersBy($column, $value)
    {
        $usersTable = Users::getUserTable();
        $usersQuery = $usersTable->find('all')->where(['Users.' . $column => $value]);
        $usersEntities = $usersQuery->count();

        return $usersEntities;
    }

    public static function getUserObject($id)
    {
        $usersTable = Users::getUserTable();
        $usersQuery = $usersTable->find('all')->where(['Users.id' => $id])->limit(1);
        $userEntity = $usersQuery->first();

        return $userEntity;
    }
}
