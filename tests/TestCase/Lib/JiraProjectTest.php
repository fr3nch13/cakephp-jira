<?php

/**
 * JiraProjectTest
 */

namespace Fr3nch13\Jira\Test\TestCase;

use Cake\TestSuite\IntegrationTestCase;
use Fr3nch13\Jira\Test\TestCase\JiraTestTrait;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Project\Project;

/**
 * JiraProjectTest class
 */
class JiraProjectTest extends IntegrationTestCase
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
        $this->tearDownJira();

        parent::tearDown();
    }

    /**
     * testGetInfo
     *
     * @return void
     */
    public function testGetInfo()
    {
        $info = $this->JiraProject->getInfo();

        $this->assertInstanceOf(Project::class, $info);
    }

    /**
     * testGetVersions
     *
     * @return void
     */
    public function testGetVersions()
    {
        $versions = $this->JiraProject->getVersions();

        $this->assertEquals($this->versions, $versions);
    }

    /**
     * testGetIssues
     *
     * @return void
     */
    public function testGetIssues()
    {
        $issues = $this->JiraProject->getIssues();

        $this->assertEquals($this->IssueSearchResult, $issues);
    }

    /**
     * testGetOpenIssues
     *
     * @return void
     */
    public function testGetOpenIssues()
    {
        $issues = $this->JiraProject->getOpenIssues();

        $this->assertEquals($this->IssueSearchResultOpen, $issues);
    }

    /**
     * testGetIssue
     *
     * @return void
     */
    public function testGetIssue()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * testGetBugs
     *
     * @return void
     */
    public function testGetBugs()
    {
        $issues = $this->JiraProject->getBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }

    /**
     * testGetOpenBugs
     *
     * @return void
     */
    public function testGetOpenBugs()
    {
        $issues = $this->JiraProject->getOpenBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }

    /**
     * modifyAllowedTypes
     *
     * @return void
     */
    public function testModifyAllowedTypes()
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
                    ]
                ]
            ]
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
    public function testIsAllowedType()
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
                    ]
                ]
            ]
        ]);

        $result = isset($this->JiraProject->allowedTypes['Test']) ? true : false;

        $this->assertEquals($this->JiraProject->isAllowedType('Test'), true);
    }

    /**
     * testGetFormData
     *
     * @return void
     */
    public function testGetFormData()
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
                    ]
                ]
            ]
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
    public function testSubmitIssue()
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
                    ]
                ]
            ]
        ]);

        // emulate submitted form data
        $data = [
            'summary' => 'Summary for TEST-7',
            'description' => 'Description for TEST-7'
        ];

        $result = $this->JiraProject->submitIssue('Test', $data);

        $this->assertEquals('7', $result);
    }
}
