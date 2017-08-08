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
}
