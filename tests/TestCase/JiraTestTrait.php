<?php
/**
 * JiraTestTrait
 */
namespace Fr3nch13\Jira\Test\TestCase;

use Cake\Core\Configure;
use Fr3nch13\Jira\Lib\JiraProject;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueSearchResult;
use JiraRestApi\Issue\Version;
use JiraRestApi\Project\Project;
use Mockery;

/**
 * Jira Test Trait
 *
 * Common variables and setup to be used in multiple tests.
 */
trait JiraTestTrait
{
    /**
     * Test subject
     *
     * @var \Fr3nch13\Jira\Lib\JiraProject
     */
    public $JiraProject;

    /**
     * The project object.
     * @var \JiraRestApi\Project\Project
     */
    public $Project = null;

    /**
     * The project service object.
     * @var \JiraRestApi\Project\ProjectService|null
     */
    public $ProjectService = null;

    /**
     * The array of JiraRestApi\Issue\Issue objects.
     * @var array
     */
    public $issues = [];

    /**
     * The issue object.
     * @var \JiraRestApi\Issue\Issue|null
     */
    public $Issue = null;

    /**
     * The issue service object - all.
     * @var \JiraRestApi\Issue\IssueSearchResult|null
     */
    public $IssueSearchResult = null;

    /**
     * The issue service object - open.
     * @var \JiraRestApi\Issue\IssueSearchResult|null
     */
    public $IssueSearchResultOpen = null;

    /**
     * The issue service object - bugs.
     * @var \JiraRestApi\Issue\IssueSearchResult|null
     */
    public $IssueSearchResultBugs = null;

    /**
     * The issue service object - feature requests.
     * @var \JiraRestApi\Issue\IssueSearchResult|null
     */
    public $IssueSearchResultFeatureRequests = null;

    /**
     * The created Issue when testing a submission.
     * @var \JiraRestApi\Issue\Issue|null
     */
    public $IssueCreatedTest = null;

    /**
     * The issue service object.
     * @var \JiraRestApi\Issue\IssueService|null
     */
    public $IssueService = null;

    /**
     * The array of JiraRestApi\Issue\Version objects.
     * @var array
     */
    public $versions = [];

    /**
     * setUpJira method
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function setUpJira()
    {
        if ($this->ProjectService === null) {
            $this->ProjectService = Mockery::mock('overload:JiraRestApi\Project\ProjectService');
        }
        if ($this->IssueService === null) {
            $this->IssueService = Mockery::mock('overload:JiraRestApi\Issue\IssueService');
        }

        $projectKey = 'TEST';

        $this->Project = new Project();
        $this->Project->setId(1)
            ->setKey($projectKey)
            ->setName('Test')
            ->setAvatarUrls([])
            ->setProjectCategory(['software'])
            ->setDescription('Description')
            ->setLead([
                'key' => 'testusername',
                'name' => 'Test User',
                'displayName' => 'Test User',
            ])
            ->setUrl('https://jira.example.com');

        for ($i = 0; $i < 3; $i++) {
            $this->versions[$i] = new Version($i . '.0.0.0');
            $this->versions[$i]->setProjectId($i)
                ->setDescription('Version ' . $i)
                ->setArchived(false)
                ->setReleased(true)
                ->setReleaseDate(null)
                ->setUserReleaseDate(null);
        }

        // create some generic issues.
        for ($i = 0; $i < 5; $i++) {
            $this->issues[$i] = new Issue();
            $this->issues[$i]->id = $i;
            $this->issues[$i]->key = $projectKey . '-' . $i;
            $this->issues[$i]->fields = new IssueField();
            $this->issues[$i]->fields->setProjectId($projectKey)
                ->setProjectKey($projectKey)
                ->setSummary(__('Summary for {0}-{1}', [$projectKey, $i]))
                ->setReporterName('Customer')
                ->setAssigneeName('Brian')
                ->setAssigneeAccountId(1)
                ->setPriorityName('Medium')
                ->setDescription(__('Description for {0}-{1}', [$projectKey, $i]))
                ->setIssueType('Task')
                ->addLabel('testing');
        }

        // add a bug issue
        $i = 5;
        $this->issues[$i] = new Issue();
        $this->issues[$i]->id = $i;
        $this->issues[$i]->key = $projectKey . '-' . $i;
        $this->issues[$i]->fields = new IssueField();
        $this->issues[$i]->fields->setProjectId($projectKey)
            ->setProjectKey($projectKey)
            ->setSummary(__('Summary for {0}-{1}', [$projectKey, $i]))
            ->setReporterName('Customer')
            ->setAssigneeName('Brian')
            ->setAssigneeAccountId(1)
            ->setPriorityName('High')
            ->setDescription(__('Description for {0}-{1}', [$projectKey, $i]))
            ->setIssueType('Bug')
            ->addLabel('customer-reported');

        // add a feature request
        $i = 6;
        $this->issues[$i] = new Issue();
        $this->issues[$i]->id = $i;
        $this->issues[$i]->key = $projectKey . '-' . $i;
        $this->issues[$i]->fields = new IssueField();
        $this->issues[$i]->fields->setProjectId($projectKey)
            ->setProjectKey($projectKey)
            ->setSummary(__('Summary for {0}-{1}', [$projectKey, $i]))
            ->setReporterName('Customer')
            ->setAssigneeName('Brian')
            ->setAssigneeAccountId(1)
            ->setPriorityName('Medium')
            ->setDescription(__('Description for {0}-{1}', [$projectKey, $i]))
            ->setIssueType('Task')
            ->addLabel('feature-request');

        $this->IssueSearchResult = new IssueSearchResult();
        $this->IssueSearchResult->setStartAt(1);
        $this->IssueSearchResult->setMaxResults(1000);
        $this->IssueSearchResult->setTotal(count($this->issues));
        $this->IssueSearchResult->setIssues($this->issues);

        $this->IssueSearchResultOpen = new IssueSearchResult();
        $this->IssueSearchResultOpen->setStartAt(1);
        $this->IssueSearchResultOpen->setMaxResults(1000);
        $this->IssueSearchResultOpen->setTotal(2);
        $this->IssueSearchResultOpen->setIssues([$this->issues[0], $this->issues[1]]);

        $this->IssueSearchResultBugs = new IssueSearchResult();
        $this->IssueSearchResultBugs->setStartAt(1);
        $this->IssueSearchResultBugs->setMaxResults(1000);
        $this->IssueSearchResultBugs->setTotal(1);
        $this->IssueSearchResultBugs->setIssues([$this->issues[5]]);

        $this->IssueSearchResultFeatureRequests = new IssueSearchResult();
        $this->IssueSearchResultFeatureRequests->setStartAt(1);
        $this->IssueSearchResultFeatureRequests->setMaxResults(1000);
        $this->IssueSearchResultFeatureRequests->setTotal(1);
        $this->IssueSearchResultFeatureRequests->setIssues([$this->issues[6]]);

        // create the issue that gets created after a 'Test' issue is submitted.
        $this->IssueCreatedTest = new Issue();
        $this->IssueCreatedTest->self = 'https://jira.example.com/rest/api/2/issue/7';
        $this->IssueCreatedTest->id = '7';
        $this->IssueCreatedTest->key = 'TEST-7';

        $this->ProjectService->shouldReceive('get')
            ->with($projectKey)
            ->andReturn($this->Project);

        $this->ProjectService->shouldReceive('getVersions')
            ->with($projectKey)
            ->andReturn($this->versions);

        $projectKey = $projectKey;
        $this->IssueService->shouldReceive('search')
            ->withArgs(function ($query, $start, $max) use ($projectKey) {
                if ($query == '"project" = "' . $projectKey . '" ORDER BY key DESC') {
                    return true;
                }

                return false;
            })
            ->andReturn($this->IssueSearchResult);

        $this->IssueService->shouldReceive('search')
            ->withArgs(function ($query, $start, $max) use ($projectKey) {
                if ($query == '"project" = "' . $projectKey . '" AND resolution is EMPTY ORDER BY key DESC') {
                    return true;
                }

                return false;
            })
            ->andReturn($this->IssueSearchResultOpen);

        $this->IssueService->shouldReceive('search')
            ->withArgs(function ($query, $start, $max) use ($projectKey) {
                if (
                    $query == '"project" = "' . $projectKey . '" and "type" = "Bug" AND resolution is EMPTY ORDER BY key DESC'
                    || $query == '"project" = "' . $projectKey . '" and "type" = "Bug" ORDER BY key DESC'
                ) {
                    return true;
                }

                return false;
            })
            ->andReturn($this->IssueSearchResultBugs);

        $this->IssueService->shouldReceive('get')
            ->with('TEST-1')
            ->andReturn($this->issues[1]);

        $this->IssueService->shouldReceive('create')
            ->withAnyArgs()
            ->andReturn($this->IssueCreatedTest);

        $this->Issue = new Issue();
        Configure::write('Jira', [
            'schema' => env('JIRA_SCHEMA', 'https'),
            'host' => env('JIRA_HOST', null),
            'username' => env('JIRA_USERNAME', null),
            'apiKey' => env('JIRA_API_KEY', null),
            'projectKey' => env('JIRA_PROJECT_KEY', null),
        ]);
        $this->JiraProject = new JiraProject();
    }

    /**
     * tearDownJira method
     *
     * @return void
     */
    public function tearDownJira()
    {
        $this->JiraProject = null;
        $this->ProjectService = null;
        $this->Project = null;
        $this->issues = null;
        $this->Issue = null;
        $this->IssueCreatedTest = null;
        $this->IssueSearchResult = null;
        $this->IssueSearchResultBugs = null;
        $this->IssueSearchResultFeatureRequests = null;
        $this->IssueSearchResultOpen = null;
        $this->IssueService = null;
        $this->versions = null;
    }
}
