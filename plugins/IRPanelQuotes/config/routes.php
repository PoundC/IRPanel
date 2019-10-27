<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'IRPanelQuotes',
    ['path' => '/quotes'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);

Router::connect('/quotes/dashboard', ['plugin' => 'IRPanelQuotes', 'controller' => 'Quotes', 'action' => 'dashboard']);
Router::connect('/quotes/search', ['plugin' => 'IRPanelQuotes', 'controller' => 'Quotes', 'action' => 'search']);
Router::connect('/quotes/browse', ['plugin' => 'IRPanelQuotes', 'controller' => 'Quotes', 'action' => 'browse']);
Router::connect('/quotes/add', ['plugin' => 'IRPanelQuotes', 'controller' => 'Quotes', 'action' => 'add']);
Router::connect('/quotes/view/*', ['plugin' => 'IRPanelQuotes', 'controller' => 'Quotes', 'action' => 'view']);

Router::connect('/quotes/admin_dashboard', ['plugin' => 'IRPanelQuotes', 'controller' => 'Quotes', 'action' => 'adminDashboard']);
