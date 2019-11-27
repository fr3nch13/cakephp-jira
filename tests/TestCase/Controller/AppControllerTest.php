<?php
/**
 * AppControllerTest
 */
//
namespace Fr3nch\Jira\Test\TestCase\Controller;

use App\Application;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        Configure::write('debug', true);

        $this->configApplication('App\Application', [CONFIG]);
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

    public function testAdd()
    {
        //$this->markTestIncomplete('Not implemented yet.');
        $this->get('/add');

        $this->assertResponseOk();
    }

    public function testThankyou()
    {
        $this->markTestIncomplete('Not implemented yet.');
        $this->get('/thankyou');

        $this->assertResponseOk();
    }
}
