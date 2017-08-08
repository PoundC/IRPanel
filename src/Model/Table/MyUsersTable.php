<?php

namespace App\Model\Table;

use CakeDC\Users\Model\Table\UsersTable;

/**
 * Users Model
 */
class MyUsersTable extends UsersTable
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->removeBehavior('Register');
        $this->addBehavior('Register');
    }
}