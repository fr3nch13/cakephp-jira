<?php

/**
 * PluginTest
 */

namespace Fr3nch13\Jira\Test\TestCase;

use App\Application;
use Cake\Console\CommandCollection;
use Cake\Core\Configure;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use Cake\Routing\RouteCollection;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Plugin;

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
     * The Application object.
     * @var \App\Application|null
     */
    public $App = null;

    /**
     * The Plugin object to test.
     * @var \Fr3nch13\Jira\Plugin|null
     */
    public $Plugin = null;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // this makes sure the configuration in Plugin::bootstrap() is ran.
        $this->App = new Application(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config');
        $this->App->addPlugin('Fr3nch13/Jira');
        $this->Plugin = new \Fr3nch13\Jira\Plugin();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * testBootstrap
     *
     * @return void
     */
    public function testBootstrap()
    {
        $this->Plugin->bootstrap($this->App);

        // make sure it was able to read and store the config.
        $this->assertEquals(Configure::read('Jira.projectKey'), 'TEST');
    }

    /**
     * testConsole
     *
     * @return void
     */
    public function testConsole()
    {
        $commands = new CommandCollection();
        $commands = $this->Plugin->console($commands);

        $this->assertInstanceOf(CommandCollection::class, $commands);
    }

    /**
     * testMiddleware
     *
     * @return void
     */
    public function testMiddleware()
    {
        $middleware = new MiddlewareQueue();
        $middleware = $this->Plugin->middleware($middleware);

        $this->assertInstanceOf(MiddlewareQueue::class, $middleware);
    }

    /**
     * testRoutes
     *
     * @return void
     */
    public function testRoutes()
    {
        Router::resetRoutes();
        $collection = new RouteCollection();
        $routeBuilder = new RouteBuilder($collection, '');
        $this->Plugin->routes($routeBuilder);

        $url = Router::url(['plugin' => 'Fr3nch13/Jira']);

        $this->assertEquals($url, '/jira');
    }
}
