<?php
declare(strict_types=1);

/**
 * JiraHelperTest
 */
namespace Fr3nch13\Jira\Test\TestCase\View\Helper;

use App\Application;
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
     * @var \Fr3nch13\Jira\View\Helper\JiraHelper|null The helper object.
     */
    public $helper = null;

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
        if (!$this->incomplete) {
            $app = new Application(CONFIG);
            $app->bootstrap();
            $app->pluginBootstrap();
            $View = new View();
            $this->helper = new JiraHelper($View);
            $this->setUpJira();
        }
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
        if ($this->incomplete) {
            $this->markTestIncomplete('Not implemented yet.');

            return;
        }
        $info = $this->helper->getInfo();

        $this->assertInstanceOf(Project::class, $info);
    }

    /**
     * testGetVersions
     *
     * @return void
     */
    public function testGetVersions(): void
    {
        if ($this->incomplete) {
            $this->markTestIncomplete('Not implemented yet.');

            return;
        }
        $versions = $this->helper->getVersions();

        $this->assertEquals($this->versions, $versions);
    }

    /**
     * testGetIssues
     *
     * @return void
     */
    public function testGetIssues(): void
    {
        if ($this->incomplete) {
            $this->markTestIncomplete('Not implemented yet.');

            return;
        }
        $issues = $this->helper->getIssues();

        $this->assertEquals($this->IssueSearchResult, $issues);
    }

    /**
     * testGetOpenIssues
     *
     * @return void
     */
    public function testGetOpenIssues(): void
    {
        if ($this->incomplete) {
            $this->markTestIncomplete('Not implemented yet.');

            return;
        }
        $issues = $this->helper->getOpenIssues();

        $this->assertEquals($this->IssueSearchResultOpen, $issues);
    }

    /**
     * testGetIssue
     *
     * @return void
     */
    public function testGetIssue(): void
    {
        if ($this->incomplete) {
            $this->markTestIncomplete('Not implemented yet.');

            return;
        }
        $issue = $this->helper->getIssue(1);

        $this->assertInstanceOf(Issue::class, $issue);

        $this->assertEquals(1, $issue->id);
    }

    /**
     * testGetBugs
     *
     * @return void
     */
    public function testGetBugs(): void
    {
        if ($this->incomplete) {
            $this->markTestIncomplete('Not implemented yet.');

            return;
        }
        $issues = $this->helper->getBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }

    /**
     * testGetOpenBugs
     *
     * @return void
     */
    public function testGetOpenBugs(): void
    {
        if ($this->incomplete) {
            $this->markTestIncomplete('Not implemented yet.');

            return;
        }
        $issues = $this->helper->getOpenBugs();

        $this->assertEquals($this->IssueSearchResultBugs, $issues);
    }
}
