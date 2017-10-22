<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'AdminLTE',
    ['path' => '/admin-l-t-e'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

/*
 *
 * Visitor Menu Routes
 *
 */

Router::connect('/products', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'products']);
Router::connect('/pricing', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'pricing']);
Router::connect('/faq', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'faq']);
Router::connect('/about', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'about']);
Router::connect('/company', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'company']);
Router::connect('/investors', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'investors']);

