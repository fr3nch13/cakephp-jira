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

/**
 * Jira Project class
 */
class JiraProject
{
    /**
     * Config Object.
     * @var \JiraRestApi\Configuration\ArrayConfiguration|null
     */
    public $ConfigObj = null;

    /**
     * The key for the project.
     * @var string|null
     */
    public $projectKey = null;

    /**
     * The project service object.
     * @var \JiraRestApi\Project\ProjectService|null
     */
    public $ProjectService = null;

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
     * The project service object.
     * @var \JiraRestApi\Issue\IssueService|null
     */
    public $IssueService = null;

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
     * Types of issues allowed to be submitted.
     * @var array
     */
    protected $allowedTypes = [
        'Bug' => [
            'type' => 'Bug', // Must be one of the types in the $this->validTypes.
            'label' => 'bug-submitted' // The label used to tag user submitted bugs.
        ],
        'FeatureRequest' => [
            'type' => 'Story', // Must be one of the types in the $this->validTypes.
            'label' => 'feature-request' // The label used to tag feature requests.
        ]
    ];

    /**
     * Constructor
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
            if (!$this->ProjectService) {
                $this->ProjectService = new ProjectService($this->ConfigObj);
            }
            $this->Project = $this->ProjectService->get($this->projectKey);
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
            if (!$this->ProjectService) {
                $this->ProjectService = new ProjectService($this->ConfigObj);
            }
            $this->Versions = $this->ProjectService->getVersions($this->projectKey);
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

            if (!$this->IssueService) {
                $this->IssueService = new IssueService($this->ConfigObj);
            }

            $this->Issues[$cacheKey] = $this->IssueService->search($jql->getQuery(), 0, 1000);
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

            if (!$this->IssueService) {
                $this->IssueService = new IssueService($this->ConfigObj);
            }

            $this->Issues[$cacheKey] = $this->IssueService->search($jql->getQuery(), 0, 1000);
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
            if (!$this->IssueService) {
                $this->IssueService = new IssueService($this->ConfigObj);
            }
            if (!$this->issuesCache[$key] = $this->IssueService->get($key)) {
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
     * Methods used to submit an Issue to Jira.
     */

    /**
     * Gets the array for the forms when submitting an issue to Jira.
     *
     * @param string|null $type The type of issue we're submitting.
     * @return array The array of data to fill in the form with.
     */
    public function getFormData($type = null)
    {
        if (!$type) {
            return [];
        }

        if (isset($this->formData[$type])) {
            return $this->formData[$type];
        }

        return [
        ];
    }

    /**
     * Submits a feature request
     *
     * @todo Build out the feature request form in the frontend.
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
     * @todo Build out the bug form in the frontend.
     * @param array $data The array of details about the bug.
     * @return bool If the bug was successfully submitted.
     */
    public function submitBug(array $data = [])
    {
        //

        return true;
    }
}
