<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class VisitorsController extends AppController
{

    public function initialize() {

        parent::initialize();

        $this->Auth->allow(['frontpage', 'products', 'pricing', 'faq', 'about', 'company', 'investors']);
    }

    public function frontpage() {

        $this->render('frontpage', 'lander');
    }

    public function products() {

        $this->render('products', 'lander');
    }

    public function pricing() {

        $this->render('pricing', 'lander');
    }

    public function faq() {

        $this->render('faq', 'lander');
    }

    public function about() {

        $this->render('about', 'lander');
    }

    public function company() {

        $this->render('company', 'lander');
    }

    public function investors() {

        $this->render('investors', 'lander');
    }
}