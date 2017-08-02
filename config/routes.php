<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Visitors', 'action' => 'frontpage', 'frontpage']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();

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

/*
 *
 * Support Menu Routes
 *
 */

Router::connect('/chat/*', ['controller' => 'Chat', 'action' => 'online']);
Router::connect('/chatsend/*', ['controller' => 'Chat', 'action' => 'chatsend']);
Router::connect('/receive/*', ['controller' => 'Chat', 'action' => 'receive']);
Router::connect('/openchats', ['controller' => 'Chat', 'action' => 'openchats']);
Router::connect('/tickets', ['controller' => 'Support', 'action' => 'tickets']);
Router::connect('/support/view/*', ['controller' => 'Support', 'action' => 'view']);
Router::connect('/support', ['controller' => 'Support', 'action' => 'support']);
Router::connect('/contact', ['controller' => 'Support', 'action' => 'contact']);
Router::connect('/close/*', ['controller' => 'Support', 'action' => 'close']);

/*
 *
 * Search Routes
 *
 */

Router::connect('/help/*', ['controller' => 'Help', 'action' => 'help']);

/*
 *
 * Search Routes
 *
 */
Router::connect('/search/users', ['controller' => 'Search', 'action' => 'users']);


/*
 *
 * Member Menu Routes
 *
 */

Router::connect('/dashboard', ['controller' => 'Members', 'action' => 'dashboard']);
// Router::connect('/pricing', ['controller' => 'Visitors', 'action' => 'pricing']);
// Router::connect('/faq', ['controller' => 'Visitors', 'action' => 'faq']);

/*
 * CakeDC/Users Routes
 *
 */
Router::connect('/profile/*', ['controller' => 'MyUsers', 'action' => 'profile']);
Router::connect('/login', ['controller' => 'MyUsers', 'action' => 'login']);
Router::connect('/register', ['controller' => 'MyUsers', 'action' => 'register']);
Router::connect('/reset', ['controller' => 'MyUsers', 'action' => 'requestResetPassword']);

Router::extensions(['json']);