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

class JiraProjectReader
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
     * The Issues object.
     * @var \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3|null
     */
    protected $Issues = null;

    /**
     * The cached list of returned issue info from the below getIssue() method.
     * @var array
     */
    protected $issuesCache = [];

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
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getIssues()
    {
        if (!$this->Issues) {
            $jql = new JqlQuery();

            $jql->setProject($this->projectKey)
                ->addAnyExpression('ORDER BY key DESC');

            $issueService = new IssueService($this->ConfigObj);

            $this->Issues = $issueService->search($jql->getQuery(), 0, 1000);
        }

        return $this->Issues;
    }

    /**
     * Get the Project's Open Issues.
     *
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getOpenIssues()
    {
        if (!$this->Issues) {
            $jql = new JqlQuery();

            $jql->setProject($this->projectKey)
                ->addAnyExpression('AND status != "Done"')
                ->addAnyExpression('ORDER BY key DESC');

            $issueService = new IssueService($this->ConfigObj);

            $this->Issues = $issueService->search($jql->getQuery(), 0, 1000);
        }

        return $this->Issues;
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
}
