<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;

Configure::write('Users.config', ['users']);
Plugin::load('CakeDC/Users', ['routes' => false, 'bootstrap' => true]);
