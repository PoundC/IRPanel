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

Router::connect('/products', ['controller' => 'Visitors', 'action' => 'products']);
Router::connect('/pricing', ['controller' => 'Visitors', 'action' => 'pricing']);
Router::connect('/faq', ['controller' => 'Visitors', 'action' => 'faq']);
Router::connect('/about', ['controller' => 'Visitors', 'action' => 'about']);
Router::connect('/company', ['controller' => 'Visitors', 'action' => 'company']);
Router::connect('/investors', ['controller' => 'Visitors', 'action' => 'investors']);

