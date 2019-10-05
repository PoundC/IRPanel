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
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Cake\Core\Configure;

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
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));

    /**
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
     */
    $routes->applyMiddleware('csrf');

    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'frontpage', 'frontpage']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
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
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */

Plugin::routes();

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
Router::connect('/sendticket/*', ['controller' => 'Support', 'action' => 'sendticket']);

Router::connect('/markdown', ['controller' => 'Help', 'action' => 'markdown']);
Router::connect('/markdownfaq', ['controller' => 'Help', 'action' => 'markdownfaq']);
Router::connect('/help/*', ['controller' => 'Help', 'action' => 'help']);
Router::connect('/help/topic/*', ['controller' => 'Help', 'action' => 'topic']);
Router::connect('/help/tag/*', ['controller' => 'Help', 'action' => 'tag']);
Router::connect('/senduser/*', ['controller' => 'Help', 'action' => 'senduser']);
Router::connect('/convertfaq/*', ['controller' => 'Help', 'action' => 'convert']);
Router::connect('/autoanswer/*', ['controller' => 'Help', 'action' => 'autoanswer']);

/*
 *
 * Billing Routes
 *
 */

Router::connect('/billing/subscribe/*', ['controller' => 'Billing', 'action' => 'subscribe']);
Router::connect('/billing/cancel_subscribe/*', ['controller' => 'Billing', 'action' => 'cancel']);
Router::connect('/billing/dashboard', ['controller' => 'Billing', 'action' => 'dashboard']);
Router::connect('/billing/subscriptions', ['controller' => 'Billing', 'action' => 'subscriptions']);
Router::connect('/billing/history', ['controller' => 'Billing', 'action' => 'history']);

/*
 *
 * Search Routes
 *
 */

Router::connect('/search/users', ['controller' => 'Search', 'action' => 'users']);

/*
 *
 * Crontab Routes
 *
 */
Router::connect('/crontabs', ['controller' => 'Crontab', 'action' => 'logs']);
Router::connect('/crontab/*', ['controller' => 'Crontab', 'action' => 'viewlogs']);
Router::connect('/crontablogs/*', ['controller' => 'Crontab', 'action' => 'viewlog']);

/*
 *
 * Member Menu Routes
 *
 */

Router::connect('/dashboard', ['controller' => 'Members', 'action' => 'dashboard']);
// Router::connect('/pricing', ['controller' => 'Visitors', 'action' => 'pricing']);

/*
 * CakeDC/Users Routes
 *
 */

Router::plugin('CakeDC/Users', ['path' => '/users'], function ($routes) {
    $routes->fallbacks('DashedRoute');
});

Router::connect('/auth/twitter', [
    'plugin' => 'CakeDC/Users',
    'controller' => 'Users',
    'action' => 'twitterLogin',
    'provider' => 'twitter'
]);
Router::connect('/accounts/validate/*', [
    'plugin' => 'CakeDC/Users',
    'controller' => 'SocialAccounts',
    'action' => 'validate'
]);
// Google Authenticator related routes
if (Configure::read('Users.GoogleAuthenticator.login')) {
    Router::connect('/verify', ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'verify']);

    Router::connect('/resetGoogleAuthenticator', [
        'plugin' => 'CakeDC/Users',
        'controller' => 'Users',
        'action' => 'resetGoogleAuthenticator'
    ]);
}

Router::connect('/admin/change/*', ['controller' => 'Users', 'action' => 'changePassword']);
Router::connect('/admin/edit/*', ['controller' => 'Users', 'action' => 'edit']);
Router::connect('/admin/users', ['controller' => 'Users', 'action' => 'index']);
Router::connect('/oauth2callback', ['controller' => 'Users', 'action' => 'oauth2callback']);
Router::connect('/profile/*', ['controller' => 'Users', 'action' => 'profile']);
Router::connect('/profile', ['controller' => 'Users', 'action' => 'profile']);
Router::connect('/login', ['controller' => 'Users', 'action' => 'login']);
Router::connect('/logout', ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'logout']);
Router::connect('/register', ['controller' => 'Users', 'action' => 'register']);
Router::connect('/reset', ['controller' => 'Users', 'action' => 'requestResetPassword']);

Router::prefix('api', function ($routes) {
    $routes->extensions(['json', 'xml']);
    $routes->resources('Cocktails');
    $routes->fallbacks('InflectedRoute');
});
