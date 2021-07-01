<?php
declare(strict_types=1);

/**
 * AppFormTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Form;

use App\Application;
use Cake\Form\Schema;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Fr3nch13\Jira\Form\AppForm as JiraForm;
use Fr3nch13\Jira\Test\TestCase\JiraTestTrait;

/**
 * AppFormTest class
 */
class AppFormTest extends TestCase
{
    /**
     * Use the Jira Test Trait
     */
    use JiraTestTrait;

    /**
     * @var string Human name of this object.
     */
    public $humanName = '';

    /**
     * @var object|null The form object.
     */
    public $JiraForm = null;

    /**
     * @var bool Switcher to make this whole test suite incomplete.
     */
    public $incomplete = false;

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
        $this->setUpJira();

        $this->humanName = __('Task');
        $this->JiraForm = new JiraForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->tearDownJira();

        parent::tearDown();
    }

    /**
     * testGetInfo
     *
     * @return void
     */
    public function testGetFormData(): void
    {
        $data = $this->JiraForm->getFormData();

        $expected = [
            'fields' => [
                'summary' => [
                    'type' => 'text',
                    'required' => true,
                ],
                'details' => [
                    'type' => 'textarea',
                    'required' => true,
                ],
            ],
        ];

        $this->assertEquals($data, $expected);
    }

    /**
     * testGetVersions
     *
     * @return void
     */
    public function testSetFormData(): void
    {
        $this->JiraForm->setData($this->JiraForm->getFormData());
        $data = $this->JiraForm->getFormData();

        $expected = [
            'fields' => [
                'summary' => [
                    'type' => 'text',
                    'required' => true,
                ],
                'details' => [
                    'type' => 'textarea',
                    'required' => true,
                ],
            ],
        ];

        $this->assertEquals($data, $expected);
    }

    /**
     * Test schema()
     *
     * @return void
     */
    public function testSchema(): void
    {
        $schema = $this->JiraForm->getSchema();
        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertSame($schema, $this->JiraForm->getSchema(), 'Same instance each time');
    }

    /**
     * Test setValidator()
     *
     * @return void
     */
    public function testSetValidator(): void
    {
        $validator = new Validator();
        $this->JiraForm->setValidator('default', $validator);
        $this->assertSame($validator, $this->JiraForm->getValidator());
    }

    /**
     * Test validate method.
     *
     * @return void
     */
    public function testValidate()
    {
        $requestData = [];
        $this->assertFalse($this->JiraForm->validate($requestData));
        $this->assertCount(2, $this->JiraForm->getErrors());
        $requestData = [
            'summary' => 'TEST SUMMARY',
            'details' => 'test details',
        ];
        $this->assertTrue($this->JiraForm->validate($requestData));
        $this->assertCount(0, $this->JiraForm->getErrors());
    }

    /**
     * testGetIssues
     *
     * @return void
     */
    public function testExecute(): void
    {
        //$this->markTestIncomplete('Not implemented yet.');

        $requestData = [
            'summary' => 'TEST SUMMARY',
            'details' => 'test details',
        ];

        $result = $this->JiraForm->execute($requestData);

        $this->assertEquals(true, $result);
    }
}
