<?php

use Cake\Core\Configure;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'AdminLTE',
    ['path' => '/admin-l-t-e'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->extensions(['json']);
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

/*
 *
 * Support Menu Routes
 *
 */

Router::connect('/chat/*', ['plugin' => 'AdminLTE', 'controller' => 'Chat', 'action' => 'online']);
Router::connect('/chatsend/*', ['plugin' => 'AdminLTE', 'controller' => 'Chat', 'action' => 'chatsend']);
Router::connect('/receive/*', ['plugin' => 'AdminLTE', 'controller' => 'Chat', 'action' => 'receive']);
Router::connect('/openchats', ['plugin' => 'AdminLTE', 'controller' => 'Chat', 'action' => 'openchats']);

Router::connect('/tickets', ['plugin' => 'AdminLTE', 'controller' => 'Support', 'action' => 'tickets']);
Router::connect('/support/view/*', ['plugin' => 'AdminLTE', 'controller' => 'Support', 'action' => 'view']);
Router::connect('/support', ['plugin' => 'AdminLTE', 'controller' => 'Support', 'action' => 'support']);
Router::connect('/contact', ['plugin' => 'AdminLTE', 'controller' => 'Support', 'action' => 'contact']);
Router::connect('/close/*', ['plugin' => 'AdminLTE', 'controller' => 'Support', 'action' => 'close']);
Router::connect('/sendticket/*', ['plugin' => 'AdminLTE', 'controller' => 'Support', 'action' => 'sendticket']);

Router::connect('/markdown', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'markdown']);
Router::connect('/markdownfaq', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'markdownfaq']);
Router::connect('/help/*', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'help']);
Router::connect('/help/topic/*', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'topic']);
Router::connect('/help/tag/*', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'tag']);
Router::connect('/senduser/*', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'senduser']);
Router::connect('/convertfaq/*', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'convert']);
Router::connect('/autoanswer/*', ['plugin' => 'AdminLTE', 'controller' => 'Help', 'action' => 'autoanswer']);

/*
 *
 * Notifications Routes
 *
 */


Router::connect('/notifications', ['plugin' => 'AdminLTE', 'controller' => 'Notifications', 'action' => 'index']);

/*
 *
 * Messaging Routes
 *
 */


Router::connect('/messages', ['plugin' => 'AdminLTE', 'controller' => 'Messaging', 'action' => 'index']);
Router::connect('/messages/*', ['plugin' => 'AdminLTE', 'controller' => 'Messaging', 'action' => 'view']);
Router::connect('/message-reply/*', ['plugin' => 'AdminLTE', 'controller' => 'Messaging', 'action' => 'sendReply']);
Router::connect('/message-delete/*', ['plugin' => 'AdminLTE', 'controller' => 'Messaging', 'action' => 'messageDelete']);
Router::connect('/message-new', ['plugin' => 'AdminLTE', 'controller' => 'Messaging', 'action' => 'compose']);
Router::connect('/autocomplete', ['plugin' => 'AdminLTE', 'controller' => 'Messaging', 'action' => 'toAutocomplete']);

/*
 *
 * Billing Routes
 *
 */

Router::connect('/billing/subscribe/*', ['plugin' => 'AdminLTE', 'controller' => 'Billing', 'action' => 'subscribe']);
Router::connect('/billing/cancel_subscribe/*', ['plugin' => 'AdminLTE', 'controller' => 'Billing', 'action' => 'cancel']);
Router::connect('/billing/dashboard', ['plugin' => 'AdminLTE', 'controller' => 'Billing', 'action' => 'dashboard']);
Router::connect('/billing/subscriptions', ['plugin' => 'AdminLTE', 'controller' => 'Billing', 'action' => 'subscriptions']);
Router::connect('/billing/history', ['plugin' => 'AdminLTE', 'controller' => 'Billing', 'action' => 'history']);

/*
 *
 * Search Routes
 *
 */

Router::connect('/search/users', ['plugin' => 'AdminLTE', 'controller' => 'Search', 'action' => 'users']);

/*
 *
 * Crontab Routes
 *
 */
Router::connect('/crontabs', ['plugin' => 'AdminLTE', 'controller' => 'Crontab', 'action' => 'logs']);
Router::connect('/crontab/*', ['plugin' => 'AdminLTE', 'controller' => 'Crontab', 'action' => 'viewlogs']);
Router::connect('/crontablogs/*', ['plugin' => 'AdminLTE', 'controller' => 'Crontab', 'action' => 'viewlog']);

/*
 *
 * Member Menu Routes
 *
 */

Router::connect('/dashboard', ['plugin' => 'AdminLTE', 'controller' => 'Members', 'action' => 'dashboard']);
// Router::connect('/pricing', ['plugin' => 'AdminLTE', 'controller' => 'Visitors', 'action' => 'pricing']);

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

Router::connect('/admin/change/*', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'changePassword']);
Router::connect('/admin/edit/*', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'edit']);
Router::connect('/admin/users', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'index']);
Router::connect('/oauth2callback', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'oauth2callback']);
Router::connect('/profile/*', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'profile']);
Router::connect('/profile', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'profile']);
Router::connect('/login', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'login']);
Router::connect('/logout', ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'logout']);
Router::connect('/register', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'register']);
Router::connect('/reset', ['plugin' => 'AdminLTE', 'controller' => 'Users', 'action' => 'requestResetPassword']);
