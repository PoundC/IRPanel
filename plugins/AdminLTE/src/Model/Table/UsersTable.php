<?php

namespace AdminLTE\Model\Table;

use CakeDC\Users\Model\Table\UsersTable as BaseUsersTable;

/**
 * Users Model
 */
class UsersTable extends BaseUsersTable
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->hasMany('users_subscriptions', ['className' => 'UsersSubscriptions'])->setForeignKey('user_id')->setProperty('user');

        $this->setTable('users');
        $this->setEntityClass('AdminLTE\Model\Entity\User');

        $this->removeBehavior('Register');
        $this->addBehavior('AdminLTE.Register');
    }
}
