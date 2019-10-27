<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'IRPanelVetting',
    ['path' => '/i-r-panel-vetting'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::connect('/voting/nominations', ['plugin' => 'IRPanelVetting', 'controller' => 'Vets', 'action' => 'nominations']);
