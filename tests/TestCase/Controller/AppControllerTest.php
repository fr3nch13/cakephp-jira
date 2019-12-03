<?php
/**
 * AppControllerTest
 */
//
namespace Fr3nch\Jira\Test\TestCase\Controller;

use App\Application;
use Cake\Core\Configure;
use Cake\Routing\RouteBuilder;
use Cake\Routing\RouteCollection;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Test\TestCase\JiraTestTrait;

/**
 * App Controller Test
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class AppControllerTest extends TestCase
{
    /**
     * Load in integration stuff.
     */
    use IntegrationTestTrait;

    /**
     * Use the Jira Test Trait
     */
    use JiraTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        Configure::write('debug', true);

        $app = new Application(CONFIG);
        $app->bootstrap();
        $app->pluginBootstrap();
        $collection = new RouteCollection();
        $routeBuilder = new RouteBuilder($collection, '');
        $app->pluginRoutes($routeBuilder);
        $this->setUpJira();
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
     * testAdd
     */
    public function testAdd()
    {
        $this->get('/jira/app/add');

        $this->assertResponseOk();
    }

    public function testThankyou()
    {
        $this->get('/jira/app/thankyou');

        $this->assertResponseOk();
    }
}
