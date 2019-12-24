<?php
declare(strict_types=1);

/**
 * PluginTest
 */

namespace Fr3nch13\Jira\Test\TestCase;

use App\Application;
use Cake\Core\Configure;
use Cake\Routing\RouteBuilder;
use Cake\Routing\RouteCollection;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * PluginTest class
 */
class PluginTest extends TestCase
{
    /**
     * Apparently this is the new Cake way to do integration.
     */
    use IntegrationTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * testBootstrap
     *
     * @return void
     */
    public function testBootstrap(): void
    {
        $app = new Application(CONFIG);
        $app->bootstrap();
        $app->pluginBootstrap();
        $plugins = $app->getPlugins();

        $this->assertSame('Fr3nch13/Jira', $plugins->get('Fr3nch13/Jira')->getName());

        // make sure it was able to read and store the config.
        $this->assertEquals(Configure::read('Jira.projectKey'), 'TEST');
    }

    /**
     * testRoutes
     *
     * @return void
     */
    public function testRoutes(): void
    {
        $app = new Application(CONFIG);
        $app->bootstrap();
        $app->pluginBootstrap();
        $collection = new RouteCollection();
        $routeBuilder = new RouteBuilder($collection, '');
        $app->pluginRoutes($routeBuilder);
        $plugins = $app->getPlugins();

        $url = Router::url(['plugin' => 'Fr3nch13/Jira', 'controller' => 'Bugs']);

        $this->assertEquals($url, '/jira/bugs');
    }
}
