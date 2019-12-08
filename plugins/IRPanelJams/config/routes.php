<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'IRPanelJams',
    ['path' => '/i_r_c_jams'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
Router::connect('/i_r_c_jams/jams/ajax_player/*', ['plugin' => 'IRPanelJams', 'controller' => 'Jams', 'action' => 'ajaxPlayer']);
Router::connect('/i_r_c_jams/jams/ajax_played/*', ['plugin' => 'IRPanelJams', 'controller' => 'Jams', 'action' => 'ajaxPlayed']);
