<?php
declare(strict_types=1);

/**
 * JiraProjectTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Lib;

use App\Application;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingAllowedTypeException;
use Fr3nch13\Jira\Exception\MissingConfigException;
use Fr3nch13\Jira\Exception\MissingDataException;
use Fr3nch13\Jira\Exception\MissingIssueException;
use Fr3nch13\Jira\Exception\MissingIssueFieldException;
use Fr3nch13\Jira\Test\TestCase\JiraTestTrait;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueField;
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
     * testConfigure
     *
     * @return void
     */
    public function testConfigure(): void
    {
        $this->JiraProject->configure();

        $this->assertInstanceOf(\JiraRestApi\Configuration\ArrayConfiguration::class, $this->JiraProject->ConfigObj);
    }

    /**
     * testConfigure
     *
     * @return void
     */
    public function testConfigureException_jiraLogFile(): void
    {
        $this->expectException(MissingConfigException::class);
        Configure::delete('Jira.jiraLogFile');
        $this->JiraProject->configure();
    }

    /**
     * testConfigure
     *
     * @return void
     */
    public function testConfigureException_useV3RestApi(): void
    {
        $this->expectException(MissingConfigException::class);
        Configure::delete('Jira.useV3RestApi');
        $this->JiraProject->configure();
    }

    /**
     * testConfigure
     *
     * @return void
     */
    public function testConfigureException_projectKey(): void
    {
        $this->expectException(MissingConfigException::class);
        Configure::delete('Jira.projectKey');
        $this->JiraProject->configure();
    }

    /**
     * testConfigure
     *
     * @return void
     */
    public function testConfigureException_apiKey(): void
    {
        $this->expectException(MissingConfigException::class);
        Configure::delete('Jira.apiKey');
        $this->JiraProject->configure();
    }

    /**
     * testConfigure
     *
     * @return void
     */
    public function testConfigureException_username(): void
    {
        $this->expectException(MissingConfigException::class);
        Configure::delete('Jira.username');
        $this->JiraProject->configure();
    }

    /**
     * testConfigure
     *
     * @return void
     */
    public function testConfigureException_host(): void
    {
        $this->expectException(MissingConfigException::class);
        Configure::delete('Jira.host');
        $this->JiraProject->configure();
    }

    /**
     * testConfigure
     *
     * @return void
     */
    public function testConfigureException_schema(): void
    {
        $this->expectException(MissingConfigException::class);
        Configure::delete('Jira.schema');
        $this->JiraProject->configure();
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
     * testGetIssue no key
     *
     * @return void
     */
    public function testGetIssueNoKey(): void
    {
        $this->expectException(MissingDataException::class);

        $issue = $this->JiraProject->getIssue();
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
     * Get Allowed Types
     *
     * @return void
     */
    public function testGetAllowedTypes(): void
    {
        $this->expectException(MissingAllowedTypeException::class);

        $issue = $this->JiraProject->getAllowedTypes('dontexist');
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
    public function testModifyAllowedTypesMissingSettings(): void
    {
        $this->expectException(MissingIssueFieldException::class);
        $this->JiraProject->modifyAllowedTypes('dontexist');
    }

    /**
     * modifyAllowedTypes
     *
     * @return void
     */
    public function testModifyAllowedTypesMissingFormData(): void
    {
        $this->expectException(MissingIssueFieldException::class);
        $this->JiraProject->modifyAllowedTypes('dontexist', [
            'jiraType' => 'Task',
        ]);
    }

    /**
     * modifyAllowedTypes
     *
     * @return void
     */
    public function testModifyAllowedTypesMissingFormDataFields(): void
    {
        $this->expectException(MissingIssueFieldException::class);
        $this->JiraProject->modifyAllowedTypes('dontexist', [
            'jiraType' => 'Task',
            'formData' => [],
        ]);
    }

    /**
     * modifyAllowedTypes
     *
     * @return void
     */
    public function testModifyAllowedTypesMissingFormDataFieldsSummary(): void
    {
        $this->expectException(MissingIssueFieldException::class);
        $this->JiraProject->modifyAllowedTypes('dontexist', [
            'jiraType' => 'Task',
            'formData' => [
                'fields' => [],
            ],
        ]);
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
     * testSetFormData
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
     * testSetFormData
     *
     * @return void
     */
    public function testSetFormDataExceptionMissingAllowed(): void
    {
        $this->expectException(MissingAllowedTypeException::class);
        $this->JiraProject->setFormData('nontexist');
    }

    /**
     * testSetFormData
     *
     * @return void
     */
    public function testSetFormDataExceptionMissingData(): void
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

        $this->expectException(MissingDataException::class);
        $this->JiraProject->setFormData('Test');
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
     * testGetFormData
     *
     * @return void
     */
    public function testGetFormDataExceptionNoType(): void
    {
        $this->expectException(MissingAllowedTypeException::class);
        $this->JiraProject->getFormData();
    }

    /**
     * testGetFormData
     *
     * @return void
     */
    public function testGetFormDataExceptionNotAllowed(): void
    {
        $this->expectException(MissingAllowedTypeException::class);
        $this->JiraProject->getFormData('dontexist');
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

    /**
     * testSubmitIssue
     *
     * @return void
     */
    public function testSubmitIssueExceptionSummary(): void
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

        $this->expectException(MissingIssueFieldException::class);
        $result = $this->JiraProject->submitIssue('Test', []);
    }

    /**
     * testSubmitIssue
     *
     * @return void
     */
    public function testSubmitIssueExceptionNotAllowed(): void
    {
        $this->expectException(MissingAllowedTypeException::class);
        $result = $this->JiraProject->submitIssue('dontexist');
    }

    /**
     * buildSubmittedIssue
     *
     * @return void
     */
    public function testBuildSubmittedIssue(): void
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
            'summary' => 'Build Issue Summary',
            'description' => 'Build Issue Description',
            'priority' => 'High',
            'assignee' => 'someguy',
            'version' => '1.0.0',
            'components' => 'frontend',
            'duedate' => '2022-11-03',
        ];

        $result = $this->JiraProject->buildSubmittedIssue('Test', $data);

        $this->assertInstanceOf(IssueField::class, $result);

        $this->assertInstanceOf(\JiraRestApi\Issue\IssueType::class, $result->issuetype);
        $this->assertEquals('Task', $result->issuetype->name);
        $this->assertInstanceOf(\JiraRestApi\Issue\Priority::class, $result->priority);
        $this->assertEquals('High', $result->priority->name);
        $this->assertInstanceOf(Project::class, $result->project);
        $this->assertEquals('TEST', $result->project->key);
        $this->assertIsArray($result->components);
        $this->assertInstanceOf(\JiraRestApi\Issue\Component::class, $result->components[0]);
        $this->assertEquals('frontend', $result->components[0]->name);
        $this->assertInstanceOf(\JiraRestApi\Issue\Reporter::class, $result->assignee);
        $this->assertEquals('someguy', $result->assignee->name);
        $this->assertIsArray($result->versions);
        $this->assertInstanceOf(\JiraRestApi\Issue\Version::class, $result->versions[0]);
        $this->assertEquals('1.0.0', $result->versions[0]->name);
        $this->assertEquals('2022-11-03', $result->duedate);
    }

    /**
     * testSetJiraError
     *
     * @return void
     */
    public function testSetJiraError(): void
    {
        $result = $this->JiraProject->setJiraError();
        $this->assertEquals(false, $result);

        $result = $this->JiraProject->setJiraError('Message');
        $this->assertEquals(true, $result);

        $result = $this->JiraProject->setJiraError('Message', 'Key');
        $this->assertEquals(true, $result);

        $expected = [
            'Key' => 'Message',
            0 => 'Message',
        ];
        $this->assertEquals($expected, $this->JiraProject->getJiraErrors());
    }

    /**
     * testExtractJiraError
     *
     * @return void
     */
    public function testExtractJiraError(): void
    {
        $jiraError = 'Error Message : {"errorMessages":[],"errors":{"user_type":"Field \'user_type\' cannot be set. It is not on the appropriate screen, or unknown."}}             ';

        $expected = 'Field \'user_type\' cannot be set. It is not on the appropriate screen, or unknown.';
        $this->assertEquals($expected, $this->JiraProject->extractJiraError($jiraError));
    }
}
