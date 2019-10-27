<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'IRPanelVoting',
    ['path' => '/voting'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::connect('/voting/search', ['plugin' => 'IRPanelVoting', 'controller' => 'Votes', 'action' => 'search']);
Router::connect('/voting/proposals', ['plugin' => 'IRPanelVoting', 'controller' => 'Votes', 'action' => 'proposals']);
Router::connect('/voting/create', ['plugin' => 'IRPanelVoting', 'controller' => 'Votes', 'action' => 'create']);
Router::connect('/voting/vote/*', ['plugin' => 'IRPanelVoting', 'controller' => 'Votes', 'action' => 'vote']);
