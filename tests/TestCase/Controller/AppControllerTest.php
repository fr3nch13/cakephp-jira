<?php
/**
 * AppControllerTest
 */
//
namespace Fr3nch\Jira\Test\TestCase\Controller;

use Cake\Core\Configure;
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
