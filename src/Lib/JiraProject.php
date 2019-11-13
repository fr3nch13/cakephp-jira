<?php
/**
 * JiraProjectReader
 */

namespace Fr3nch13\Jira\Lib;

use Cake\Core\Configure;
use Fr3nch13\Jira\Exception\Exception;
use Fr3nch13\Jira\Exception\MissingConfigException;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\JqlQuery;
use JiraRestApi\Project\ProjectService;

class JiraProject
{
    /**
     * Config Object.
     * @var \JiraRestApi\Configuration\ArrayConfiguration|null
     */
    protected $ConfigObj = null;

    /**
     * The key for the project.
     * @var string|null
     */
    protected $projectKey = null;

    /**
     * The project object.
     * @var \JiraRestApi\Project\Project|null
     */
    protected $Project = null;

    /**
     * The list of a Project's Versions.
     * @var \ArrayObject|null
     */
    protected $Versions = null;

    /**
     * The Cached list of issues.
     * @var array|null
     */
    protected $Issues = null;

    /**
     * The cached list of returned issue info from the below getIssue() method.
     * @var array
     */
    protected $issuesCache = [];

    /**
     * Valid Types.
     * Used to ensure we're getting a valid type when filtering.
     * Currently only support Jira Core and Software.
     * @see https://confluence.atlassian.com/adminjiracloud/issue-types-844500742.html
     * @var array
     */
    protected $validTypes = [
        'Bug',
        'Epic',
        'Story',
        'Subtask',
        'Task',
    ];

    /**
     * The Issue Type for featured Requests.
     * Must be one of the types in the $this->validTypes.
     * @var string
     */
    protected $typeFeatureRequest = 'Story';

    /**
     * The label used to tag feature requests.
     * @var string
     */
    protected $labelFeatureRequest = 'feature-request';

    /**
     * The Issue Type for featured Requests.
     * Must be one of the types in the $this->validTypes.
     * @var string
     */
    protected $typeBug = 'Bug';

    /**
     * Initializer
     *
     * Reads the configuration, and crdate a config object to be passed to the other objects.
     *
     * @return void
     * @throws \Fr3nch13\Jira\Exception\MissingConfigException When a config setting isn't set.
     */
    public function __construct()
    {
        $schema = Configure::read('Jira.schema');
        if (!$schema) {
            throw new MissingConfigException('schema');
        }
        $host = Configure::read('Jira.host');
        if (!$host) {
            throw new MissingConfigException('host');
        }
        $username = Configure::read('Jira.username');
        if (!$username) {
            throw new MissingConfigException('username');
        }
        $apiKey = Configure::read('Jira.apiKey');
        if (!$apiKey) {
            throw new MissingConfigException('apiKey');
        }
        $projectKey = Configure::read('Jira.projectKey');
        if (!$projectKey) {
            throw new MissingConfigException('projectKey');
        }
        $this->ConfigObj = new ArrayConfiguration([
            'jiraHost' => $schema . '://' . $host,
            'jiraUser' => $username,
            'jiraPassword' => $apiKey,
        ]);

        $this->projectKey = $projectKey;
    }

    /**
     * Get the Project's Info.
     *
     * @return \JiraRestApi\Project\Project The information about the project.
     * @throws \Fr3nch13\Jira\Exception\MissingProjectException If the project can't be found.
     */
    public function getInfo()
    {
        if (!$this->Project) {
            $projSvc = new ProjectService($this->ConfigObj);
            $this->Project = $projSvc->get($this->projectKey);
        }

        return $this->Project;
    }

    /**
     * Get the Project's Versions.
     *
     * @return \ArrayObject A list of version objects.
     */
    public function getVersions()
    {
        if (!$this->Versions) {
            $projSvc = new ProjectService($this->ConfigObj);
            $this->Versions = $projSvc->getVersions($this->projectKey);
        }

        return $this->Versions;
    }

    /**
     * Get the Project's Issues.
     *
     * @param string|null $type Filter the Issues by type.
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getIssues($type = null)
    {
        $cacheKey = 'all';
        if ($type) {
            $cacheKey .= '-' . $type;
        }
        if (!isset($this->Issues[$cacheKey])) {
            $jql = new JqlQuery();

            $jql->setProject($this->projectKey);
            if ($type && in_array($type, $this->validTypes)) {
                $jql->setType($type);
            }
            $jql->addAnyExpression('ORDER BY key DESC');

            $issueService = new IssueService($this->ConfigObj);

            $this->Issues[$cacheKey] = $issueService->search($jql->getQuery(), 0, 1000);
        }

        return $this->Issues[$cacheKey];
    }

    /**
     * Get the Project's Open Issues.
     *
     * @param string|null $type Filter the Issues by type.
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getOpenIssues($type = null)
    {
        $cacheKey = 'open';
        if ($type) {
            $cacheKey .= '-' . $type;
        }
        if (!isset($this->Issues[$cacheKey])) {
            $jql = new JqlQuery();

            $jql->setProject($this->projectKey);
            if ($type && in_array($type, $this->validTypes)) {
                $jql->setType($type);
            }
            $jql->addAnyExpression('AND resolution is EMPTY');
            $jql->addAnyExpression('ORDER BY key DESC');

            $issueService = new IssueService($this->ConfigObj);

            $this->Issues[$cacheKey] = $issueService->search($jql->getQuery(), 0, 1000);
        }

        return $this->Issues[$cacheKey];
    }

    /**
     * Gets info on a particular issue within your project.
     *
     * @param int $id The issue id. The integer part without the project key.
     * @return \JiraRestApi\Issue\Issue|\JiraRestApi\Issue\IssueV3 the object that has the info of that issue.
     * @throws \Fr3nch13\Jira\Exception\Exception If the issue's id isn't given.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueException If the project's issue can't be found.
     */
    public function getIssue($id = null)
    {
        if (!$id) {
            throw new Exception(__('Missing the Issue\'s ID.'));
        }
        $key = $this->projectKey . '-' . $id;
        if (!isset($this->issuesCache[$key])) {
            $issueService = new IssueService($this->ConfigObj);
            if (!$this->issuesCache[$key] = $issueService->get($key)) {
                throw new MissingIssueException($key);
            }
        }

        return $this->issuesCache[$key];
    }

    /**
     * Gets a list of issues that are considered bugs.
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getBugs()
    {
        return $this->getIssues('Bug');
    }

    /**
     * Gets a list of open issues that are considered bugs.
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getOpenBugs()
    {
        return $this->getOpenIssues('Bug');
    }

    /**
     * Submits a feature request
     *
     * @param array $data The array of details about the feature request.
     * @return bool If the request was successfully submitted.
     */
    public function submitFeatureRequest(array $data = [])
    {
        //

        return true;
    }

    /**
     * Submits a bug.
     *
     * @param array $data The array of details about the bug.
     * @return bool If the bug was successfully submitted.
     */
    public function submitBug(array $data = [])
    {
        //

        return true;
    }
}
