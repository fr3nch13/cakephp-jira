<?php
declare(strict_types=1);

/**
 * Plugin Definitions
 */

namespace Fr3nch13\Jira;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/**
 * Plugin Definitions
 */
class Plugin extends BasePlugin
{
    /**
     * Bootstraping for this specific plugin.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The app object.
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        // Add constants, load configuration defaults,
        // and initiate any required cakephp plugins.

        // detect which major version of php we're running,
        // and only filter if the version is greater than 7.
        $jiraHost = env('JIRA_HOST', false);
        if ($jiraHost) {
            $version = explode('.', PHP_VERSION);
            if ((int)$version[0] >= 7) {
                $jiraHost = filter_var($jiraHost, FILTER_VALIDATE_DOMAIN);
            }
        }

        if (!Configure::read('Jira')) {
            if (!defined('LOGS')) {
                define('LOGS', '/tmp/');
            }
            Configure::write('Jira', [
                'schema' => env('JIRA_SCHEMA', 'https'),
                'host' => $jiraHost,
                'username' => env('JIRA_USERNAME', null),
                'apiKey' => env('JIRA_API_KEY', null),
                'projectKey' => env('JIRA_PROJECT_KEY', null),
                'useV3RestApi' => env('JIRA_REST_API_V3', true),
                'jiraLogFile' => LOGS . 'jira-client.log',
            ]);
        }

        // By default will load `config/bootstrap.php` in the plugin.
        parent::bootstrap($app);
    }

    /**
     * Add plugin specific routes here.
     *
     * @param \Cake\Routing\RouteBuilder $routes The passed routes object.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        // Add routes.
        $routes->plugin(
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
