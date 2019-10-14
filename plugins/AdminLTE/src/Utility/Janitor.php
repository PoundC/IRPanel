<?php

namespace AdminLTE\Utility;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class Janitor
{
    // TODO: Throw 500 Error, Possibly Fake Code/SQL to make the hacker think they have a SQL Injection possible attack
    public static function hackAttempt()
    {
        die('500 Error');
    }
}
