<?php

namespace App\Controller;

use App\Controller\AppController;
use CakeDC\Users\Model\Table\UsersTable;
use Cake\Event\Event;
use CakeDC\Users\Controller\Component\UsersAuthComponent;
use App\Controller\Traits\LoginTrait;
use App\Controller\Traits\ProfileTrait;
use CakeDC\Users\Controller\Traits\ReCaptchaTrait;
use CakeDC\Users\Controller\Traits\RegisterTrait;
use CakeDC\Users\Controller\Traits\SimpleCrudTrait;
use CakeDC\Users\Controller\Traits\SocialTrait;

class MyUsersController extends AppController
{
    use LoginTrait;
    use ProfileTrait;
    use ReCaptchaTrait;
    use RegisterTrait;
    use SimpleCrudTrait;
    use SocialTrait;
}
