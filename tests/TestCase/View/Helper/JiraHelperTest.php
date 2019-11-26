<?php
/**
 * JiraHelperTest
 */
namespace Fr3nch13\Jira\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Fr3nch13\Jira\Test\TestCase\JiraTestTrait;
use Fr3nch13\Jira\View\Helper\JiraHelper;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Project\Project;

/**
 * JiraHelperTest
 */
class JiraHelperTest extends TestCase
{
    /**
     * Use the Jira Test Trait
     */
    use JiraTestTrait;

    /**
     * The helper object.
     * @var \Fr3nch13\Jira\View\Helper\JiraHelper|null
     */
    public $helper = null;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->setUpJira();

        $View = new View();
        $this->helper = new JiraHelper($View);
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
        $info = $this->helper->getInfo();

        $this->assertInstanceOf(Project::class, $info);
    }

    /**
     * testGetVersions
     *
     * @return void
     */
    public function testGetVersions()
    {
        $versions = $this->helper->getVersions();

        $this->assertEquals($this->versions, $versions);
    }

    /**
     * testGetIssues
     *
     * @return void
     */
    public function testGetIssues()
    {
        $issues = $this->helper->getIssues();

        $this->assertEquals($this->IssueSearchResult, $issues);
    }

    /**
     * testGetOpenIssues
     *
     * @return void
     */
    public function testGetOpenIssues()
    {
        $issues = $this->helper->getOpenIssues();

        $this->assertEquals($this->IssueSearchResultOpen, $issues);
    }

    /**
     * testGetIssue
     *
     * @return void
     */
    public function testGetIssue()
    {
        $issue = $this->helper->getIssue(1);

        $this->assertInstanceOf(Issue::class, $issue);

        $this->assertEquals(1, $issue->id);
    }

    /**
     * testGetBugs
     *
     * @return void
     */
    public function testGetBugs()
    {
        $issues = $this->helper->getBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }

    /**
     * testGetOpenBugs
     *
     * @return void
     */
    public function testGetOpenBugs()
    {
        $issues = $this->helper->getOpenBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }
}
