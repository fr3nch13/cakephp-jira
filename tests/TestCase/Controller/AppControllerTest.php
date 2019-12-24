<?php
declare(strict_types=1);

/**
 * AppControllerTest
 */
namespace Fr3nch\Jira\Test\TestCase\Controller;

use App\Application;
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
    public function setUp(): void
    {
        parent::setUp();

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
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * testAdd
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/jira/app/add');

        $this->assertResponseOk();
        $this->assertResponseContains('action="/jira/app/add"');
    }

    /**
     * testThankyou
     *
     * @return void
     */
    public function testThankyou(): void
    {
        $this->get('/jira/app/thankyou');

        //debug((string)$this->_response->getBody());
        //debug($this->_response->getHeaders());

        $this->assertResponseOk();
        $this->assertResponseContains('<h4>Thank you for submitting the Report.</h4>');
    }
}
