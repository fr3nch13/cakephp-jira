<?php
/**
 * Plugin Definitions
 */

namespace Fr3nch13\Jira;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventManager;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * Plugin Definitions
 */
class Plugin extends BasePlugin
{
    /**
     * Load needed Middleware
     *
     * @param object $middleware The passed middleware object.
     * @return object The modified middleware object.
     */
    public function middleware($middleware)
    {
        // Add middleware here.

        return parent::middleware($middleware);
    }

    /**
     * Add plugin specific commands here.
     *
     * @param object $commands The passed commands object.
     * @return object The modified commands object.
     */
    public function console($commands)
    {
        // Add console commands here.

        return parent::console($commands);
    }

    /**
     * Bootstraping for this specific plugin.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The app object.
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app)
    {
        // Add constants, load configuration defaults,
        // and initiate any required cakephp plugins.
        //$app->addPlugin('Vendor/PluginName');
        Configure::write('Jira', [
            'schema' => env('JIRA_SCHEMA', 'https'),
            'host' => filter_var(env('JIRA_HOST', false), FILTER_VALIDATE_DOMAIN),
            'username' => env('JIRA_USERNAME', null),
            'apiKey' => env('JIRA_API_KEY', null),
            'projectKey' => env('JIRA_PROJECT_KEY', null),
        ]);

        // By default will load `config/bootstrap.php` in the plugin.
        parent::bootstrap($app);
    }

    /**
     * Add plugin specific routes here.
     *
     * @param object $routes The passed routes object.
     * @return void
     */
    public function routes($routes)
    {
        // Add routes.
        Router::plugin(
            'Fr3nch13/Jira',
            ['path' => '/jira'],
            function (RouteBuilder $routes) {
                $routes->fallbacks(DashedRoute::class);
            }
        );

        // By default will load `config/routes.php` in the plugin.
        parent::routes($routes);
    }
}
