<?php

/**
 * JiraProjectTest
 */

namespace Fr3nch13\Jira\Test\TestCase;

use Cake\TestSuite\IntegrationTestCase;
use Fr3nch13\Jira\Test\TestCase\JiraTestTrait;
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
     * testGetFormData
     *
     * @return void
     */
    public function testGetFormData()
    {
        $data = $this->JiraProject->getFormData();

        $this->assertEquals([], $data);
    }

    /**
     * testSubmitFeatureRequest
     *
     * @return void
     */
    public function testSubmitFeatureRequest()
    {
        $data = $this->JiraProject->submitFeatureRequest([]);

        $this->assertEquals(true, $data);
    }

    /**
     * testSubmitBug
     *
     * @return void
     */
    public function testSubmitBug()
    {
        $data = $this->JiraProject->submitBug([]);

        $this->assertEquals(true, $data);
    }
}
