<?php

/**
 * Application
 */

namespace App;

use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
{
    /**
     * Setup the middleware queue your application will use.
     * See: https://book.cakephp.org/3.0/en/controllers/middleware.html
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware($middlewareQueue)
    {
        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(ErrorHandlerMiddleware::class)

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime')
            ]))

            // Add routing middleware.
            ->add(new RoutingMiddleware($this));

        return $middlewareQueue;
    }

    /**
     * Bootstrap function for browser-based access.
     *
     * @return void
     */
    public function bootstrap()
    {
        /**
         * Load stuff needed from the cakephp core.
         */
        parent::bootstrap();

        $isCli = PHP_SAPI === 'cli';

        if ($isCli) {
            $this->bootstrapCli();
        }
    }

    /**
     * Bootstrap function for command line access.
     *
     * @return void
     */
    protected function bootstrapCli()
    {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }

        try {
            $this->addPlugin('Migrations');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }

        // Load more plugins here
    }

    /**
     * Add plugin specific routes here.
     *
     * @param object $routes The passed routes object.
     * @return void
     */
    public function routes($routes)
    {
        // By default will load `config/routes.php` in the plugin.
        parent::routes($routes);

        Router::defaultRouteClass(DashedRoute::class);
    }
}
