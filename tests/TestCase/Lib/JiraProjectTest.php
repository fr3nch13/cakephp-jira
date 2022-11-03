<?php
declare(strict_types=1);

/**
 * JiraProjectTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Lib;

use App\Application;
use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingIssueException;
use Fr3nch13\Jira\Test\TestCase\JiraTestTrait;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Project\Project;

/**
 * JiraProjectTest class
 */
class JiraProjectTest extends TestCase
{
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
        $this->setUpJira();
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
    public function testGetInfo(): void
    {
        $info = $this->JiraProject->getInfo();

        $this->assertInstanceOf(Project::class, $info);
    }

    /**
     * testGetVersions
     *
     * @return void
     */
    public function testGetVersions(): void
    {
        $versions = $this->JiraProject->getVersions();

        $this->assertIsArray($versions);
        $this->assertEquals(3, count($versions));
        $this->assertInstanceOf(\JiraRestApi\Issue\Version::class, $versions[0]);
    }

    /**
     * testGetIssues
     *
     * @return void
     */
    public function testGetIssues(): void
    {
        $issues = $this->JiraProject->getIssues();

        $this->assertEquals($this->IssueSearchResult, $issues);
    }

    /**
     * testGetOpenIssues
     *
     * @return void
     */
    public function testGetOpenIssues(): void
    {
        $issues = $this->JiraProject->getOpenIssues();

        $this->assertEquals($this->IssueSearchResultOpen, $issues);
    }

    /**
     * testGetIssue
     *
     * @return void
     */
    public function testGetIssue(): void
    {
        $issue = $this->JiraProject->getIssue(1);

        $this->assertInstanceOf(Issue::class, $issue);

        $this->assertEquals(1, $issue->id);
    }

    /**
     * testGetMissingIssue
     *
     * @return void
     */
    public function testGetMissingIssue(): void
    {
        $this->expectException(MissingIssueException::class);

        $issue = $this->JiraProject->getIssue(999);
    }

    /**
     * testGetBugs
     *
     * @return void
     */
    public function testGetBugs(): void
    {
        $issues = $this->JiraProject->getBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }

    /**
     * testGetOpenBugs
     *
     * @return void
     */
    public function testGetOpenBugs(): void
    {
        $issues = $this->JiraProject->getOpenBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }

    /**
     * modifyAllowedTypes
     *
     * @return void
     */
    public function testModifyAllowedTypes(): void
    {
        $this->JiraProject->modifyAllowedTypes('Test', [
            'jiraType' => 'Task', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'test-label', // The label used to tag user submitted bugs.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
            ],
        ]);

        $types = $this->JiraProject->getAllowedTypes();

        $result = isset($types['Test']) ? true : false;

        $this->assertEquals($result, true);
    }

    /**
     * modifyAllowedTypes
     *
     * @return void
     */
    public function testIsAllowedType(): void
    {
        $this->JiraProject->modifyAllowedTypes('Test', [
            'jiraType' => 'Task', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'test-label', // The label used to tag user submitted bugs.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
            ],
        ]);

        $result = isset($this->JiraProject->allowedTypes['Test']) ? true : false;

        $this->assertEquals($this->JiraProject->isAllowedType('Test'), true);
    }

    /**
     * testGetVersions
     *
     * @return void
     */
    public function testSetFormData(): void
    {
        $this->JiraProject->modifyAllowedTypes('Test', [
            'jiraType' => 'Task', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'test-label', // The label used to tag user submitted bugs.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
            ],
        ]);

        $expected = [
            'fields' => [
                'summary' => [
                    'type' => 'text',
                    'required' => true,
                ],
            ],
        ];

        $this->JiraProject->setFormData('Test', $expected);
        $data = $this->JiraProject->getFormData('Test');

        $this->assertEquals($data, $expected);
    }

    /**
     * testGetFormData
     *
     * @return void
     */
    public function testGetFormData(): void
    {
        $this->JiraProject->modifyAllowedTypes('Test', [
            'jiraType' => 'Task', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'test-label', // The label used to tag user submitted bugs.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
            ],
        ]);

        $data = $this->JiraProject->getFormData('Test');
        $set = isset($data['fields']['summary']['type']) ? true : false;

        // isset
        $this->assertEquals($set, true);

        // check value
        $this->assertEquals($data['fields']['summary']['type'], 'text');
    }

    /**
     * testSubmitIssue
     *
     * @return void
     */
    public function testSubmitIssue(): void
    {
        $this->JiraProject->modifyAllowedTypes('Test', [
            'jiraType' => 'Task', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'test-label', // The label used to tag user submitted bugs.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'required' => true,
                    ],
                ],
            ],
        ]);

        // emulate submitted form data
        $data = [
            'summary' => 'Summary for TEST-7',
            'description' => 'Description for TEST-7',
        ];

        $result = $this->JiraProject->submitIssue('Test', $data);

        $this->assertEquals('7', $result);
    }
}
