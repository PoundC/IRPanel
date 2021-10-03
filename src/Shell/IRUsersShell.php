<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace App\Shell;

use Cake\Core\Configure;
use CakeDC\Users\Shell\UsersShell;

/**
 * Shell with utilities for the Users Plugin
 *
 * @property UsersTable Users
 */
class IRUsersShell extends UsersShell
{
    /**
     * initialize callback
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Users = $this->loadModel('users');
    }

    public function generateUniqueUsername($username)
    {
        return $username;
    }

    /**
     * Add a new superadmin user
     *
     * @return void
     */
    public function addSuperuser()
    {
        $this->_createUser2([
            'username' => 'superadmin',
            'role' => 'superuser',
            'is_superuser' => true
        ]);
    }

    public function _createUser2($template)
    {
        if (!empty($this->params['username'])) {
            $username = $this->params['username'];
        } else {
            $username = !empty($template['username']) ?
                $template['username'] : $this->_generateRandomUsername();
        }

        $password = (empty($this->params['password']) ?
            $this->_generateRandomPassword() : $this->params['password']);
        $email = (empty($this->params['email']) ?
            $username . '@example.com' : $this->params['email']);
        $role = (empty($this->params['role']) ?
            $template['role'] : $this->params['role']);

        $user = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'active' => 1,
        ];

        $userEntity = $this->Users->newEntity($user);
        $userEntity->is_superuser = empty($template['is_superuser']) ?
            false : $template['is_superuser'];
        $userEntity->role = $role;
        $savedUser = $this->Users->save($userEntity);

        if (!empty($savedUser)) {
            if ($savedUser->is_superuser) {
                $this->out(__d('CakeDC/Users', 'Superuser added:'));
            } else {
                $this->out(__d('CakeDC/Users', 'User added:'));
            }
            $this->out(__d('CakeDC/Users', 'Id: {0}', $savedUser->id));
            $this->out(__d('CakeDC/Users', 'Username: {0}', $savedUser->username));
            $this->out(__d('CakeDC/Users', 'Email: {0}', $savedUser->email));
            $this->out(__d('CakeDC/Users', 'Role: {0}', $savedUser->role));
            $this->out(__d('CakeDC/Users', 'Password: {0}', $password));
        } else {
            $this->out(__d('CakeDC/Users', 'User could not be added:'));

            collection($userEntity->getErrors())->each(function ($error, $field) {
                $this->out(__d('CakeDC/Users', 'Field: {0} Error: {1}', $field, implode(',', $error)));
            });
        }
    }
}
