<?php

namespace App\Controller;

use App\Controller\Traits\ProfileTrait;
use CakeDC\Users\Controller\UsersController;

class MyUsersController extends UsersController
{
    use ProfileTrait;

    public function initialize() {

        parent::initialize();

        $this->Auth->allow('login');
    }

    public function register() {

        $this->set('title', 'Register User');

        parent::register();
    }

    public function login() {

        $this->set('title', 'CakeAdminLTE Login');

        parent::login();
    }

    public function requestResetPassword() {

        $this->set('title', 'Reset Password');

        parent::requestResetPassword();
    }
}
