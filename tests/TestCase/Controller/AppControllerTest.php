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
     * @var string The controller name
     */
    public $controller = 'app';

    /**
     * @var string The type of issue to submit to Jira.
     */
    public $type = 'Report';

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
    public function testAddGet(): void
    {
        $this->get('/jira/' . $this->controller . '/add');

        $this->assertResponseOk();
        $this->assertResponseContains('action="/jira/' . $this->controller . '/add"');
    }

    /**
     * testAdd
     *
     * @return void
     */
    public function testAddPostSuccess(): void
    {
        $postData = [
            'summary' => 'This is the summary',
            'details' => 'Details of the Jira issue.',
        ];
        $this->post('/jira/' . $this->controller . '/add', $postData);

        $this->assertResponseSuccess();
        $this->assertRedirectContains('/jira/' . $this->controller . '/thankyou?type=' . urlencode($this->type));
    }

    /**
     * testAdd
     *
     * @return void
     */
    public function testAddPostFail(): void
    {
        $postData = [];
        $this->post('/jira/' . $this->controller . '/add', $postData);

        $this->assertResponseOk();

        $this->assertResponseContains('<div class="error-message" id="summary-error">This field is required</div>');
        $this->assertResponseContains('<div class="error-message" id="details-error">This field is required</div>');
    }

    /**
     * testThankyou
     *
     * @return void
     */
    public function testThankyou(): void
    {
        $this->get('/jira/' . $this->controller . '/thankyou');

        //debug((string)$this->_response->getBody());
        //debug($this->_response->getHeaders());

        $this->assertResponseOk();
        $this->assertResponseContains('<h4>Thank you for submitting the ' . $this->type . '.</h4>');
    }
}
