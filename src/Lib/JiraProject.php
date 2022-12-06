<?php
declare(strict_types=1);

/**
 * JiraProjectReader
 */

namespace Fr3nch13\Jira\Lib;

use Cake\Core\Configure;
use Fr3nch13\Jira\Exception\IssueSubmissionException;
use Fr3nch13\Jira\Exception\MissingAllowedTypeException;
use Fr3nch13\Jira\Exception\MissingConfigException;
use Fr3nch13\Jira\Exception\MissingDataException;
use Fr3nch13\Jira\Exception\MissingIssueException;
use Fr3nch13\Jira\Exception\MissingIssueFieldException;
use Fr3nch13\Jira\Exception\MissingProjectException;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\JqlQuery;
use JiraRestApi\JiraException;
use JiraRestApi\Project\ProjectService;

/**
 * Jira Project class
 */
class JiraProject
{
    /**
     * @var \JiraRestApi\Configuration\ArrayConfiguration Config Object.
     */
    public $ConfigObj;

    /**
     * @var null|string The key for the project.
     */
    public $projectKey = null;

    /**
     * @var \JiraRestApi\Project\ProjectService The project service object.
     */
    public $ProjectService;

    /**
     * @var \JiraRestApi\Project\Project The project object.
     */
    protected $Project;

    /**
     * @var array<\JiraRestApi\Issue\Version> The list of a Project's Versions.
     */
    protected $Versions;

    /**
     * @var \JiraRestApi\Issue\IssueService The project service object.
     */
    public $IssueService;

    /**
     * @var array<string, mixed> The Cached list of issues.
     */
    protected $Issues = [];

    /**
     * @var array<string, mixed> The cached list of returned issue info from the below getIssue() method.
     */
    protected $issuesCache = [];

    /**
     * Valid Types.
     * Used to ensure we're getting a valid type when filtering.
     * Currently only support Jira Core and Software.
     *
     * @see https://confluence.atlassian.com/adminjiracloud/issue-types-844500742.html
     * @var array<int, string>
     */
    protected $validTypes = [
        'Bug',
        'Epic',
        'Story',
        'Subtask',
        'Task',
    ];

    /**
     * @var array<string, array<mixed>> Types of issues allowed to be submitted.
     */
    protected $allowedTypes = [
        'Task' => [
            'jiraType' => 'Task', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'task-submitted', // The label used to tag user submitted bugs.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                    'details' => [
                        'type' => 'textarea',
                        'required' => true,
                    ],
                ],
            ],
        ],
        'Bug' => [
            'jiraType' => 'Bug', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'bug-submitted', // The label used to tag user submitted bugs.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                    'details' => [
                        'type' => 'textarea',
                        'required' => true,
                    ],
                ],
            ],
        ],
        'FeatureRequest' => [
            'jiraType' => 'Story', // Must be one of the types in the $this->validTypes.
            'jiraLabels' => 'feature-request', // The label used to tag feature requests.
            // The form's field information.
            'formData' => [
                'fields' => [
                    'summary' => [
                        'type' => 'text',
                        'required' => true,
                    ],
                    'details' => [
                        'type' => 'textarea',
                        'required' => true,
                    ],
                ],
            ],
        ],
    ];

    /**
     * This is here for the Form object (or any other object) to use.
     * It tacks all errors, even if an exception is thrown.
     *
     * @var array<int|string, string>
     */
    protected $errors = [];

    /**
     * Constructor
     *
     * Reads the configuration, and crdate a config object to be passed to the other objects.
     *
     * @throws \Fr3nch13\Jira\Exception\MissingProjectException When the project can't be found.
     * @return void
     */
    public function __construct()
    {
        $this->configure();

        // setup the objects
        $this->ProjectService = new ProjectService($this->ConfigObj);
        try {
            $this->Project = $this->ProjectService->get($this->projectKey);
        } catch (JiraException $e) {
            $this->setJiraError($this->projectKey, 'MissingProjectException');
            throw new MissingProjectException($this->projectKey);
        }

        $this->Versions = (array)$this->ProjectService->getVersions($this->projectKey);
        $this->IssueService = new IssueService($this->ConfigObj);
    }

    /**
     * Configures the object.
     * Broken out of construct.
     *
     * @throws \Fr3nch13\Jira\Exception\MissingConfigException When a config setting isn't set.
     * @return void
     */
    public function configure(): void
    {
        $schema = Configure::read('Jira.schema');
        if (!$schema) {
            $this->setJiraError('schema', 'MissingConfigException');
            throw new MissingConfigException('schema');
        }
        $host = Configure::read('Jira.host');
        if (!$host) {
            $this->setJiraError('host', 'MissingConfigException');
            throw new MissingConfigException('host');
        }
        $username = Configure::read('Jira.username');
        if (!$username) {
            $this->setJiraError('username', 'MissingConfigException');
            throw new MissingConfigException('username');
        }
        $apiKey = Configure::read('Jira.apiKey');
        if (!$apiKey) {
            $this->setJiraError('apiKey', 'MissingConfigException');
            throw new MissingConfigException('apiKey');
        }
        $projectKey = Configure::read('Jira.projectKey');
        if (!$projectKey) {
            $this->setJiraError('projectKey', 'MissingConfigException');
            throw new MissingConfigException('projectKey');
        }
        $useV3RestApi = Configure::read('Jira.useV3RestApi');
        if (!$useV3RestApi) {
            $this->setJiraError('useV3RestApi', 'MissingConfigException');
            throw new MissingConfigException('useV3RestApi');
        }
        $jiraLogFile = Configure::read('Jira.jiraLogFile');
        if (!$jiraLogFile) {
            $this->setJiraError('jiraLogFile', 'MissingConfigException');
            throw new MissingConfigException('jiraLogFile');
        }
        $this->ConfigObj = new ArrayConfiguration([
            'jiraHost' => $schema . '://' . $host,
            'jiraUser' => $username,
            'jiraPassword' => $apiKey,
            'useV3RestApi' => $useV3RestApi,
            'jiraLogFile' => $jiraLogFile,
        ]);

        $this->projectKey = $projectKey;
    }

    /**
     * Get the Project's Info.
     *
     * @return \JiraRestApi\Project\Project The information about the project.
     * @throws \Fr3nch13\Jira\Exception\MissingProjectException If the project can't be found.
     */
    public function getInfo(): \JiraRestApi\Project\Project
    {
        return $this->Project;
    }

    /**
     * Get the Project's Versions.
     *
     * @return array<\JiraRestApi\Issue\Version> A list of version objects.
     */
    public function getVersions(): array
    {
        return $this->Versions;
    }

    /**
     * Get the Project's Issues.
     *
     * @param string|null $type Filter the Issues by type.
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getIssues(?string $type = null): \JiraRestApi\Issue\IssueSearchResult
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
    public function getOpenIssues(?string $type = null): \JiraRestApi\Issue\IssueSearchResult
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

            $this->Issues[$cacheKey] = $this->IssueService->search($jql->getQuery(), 0, 1000);
        }

        return $this->Issues[$cacheKey];
    }

    /**
     * Gets info on a particular issue within your project.
     *
     * @param int|null $id The issue id. The integer part without the project key.
     * @throws \Fr3nch13\Jira\Exception\MissingDataException If the issue's id isn't given.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueException If the project's issue can't be found.
     * @return \JiraRestApi\Issue\Issue|\JiraRestApi\Issue\IssueV3 the object that has the info of that issue.
     */
    public function getIssue(?int $id = null): \JiraRestApi\Issue\Issue
    {
        if (!is_int($id)) {
            $this->setJiraError(__('Missing the Issue\'s ID.'), 'Exception');
            throw new MissingDataException(__('Missing the Issue\'s ID.'));
        }
        $key = $this->projectKey . '-' . $id;
        if (!isset($this->issuesCache[$key])) {
            try {
                $this->issuesCache[$key] = $this->IssueService->get($key);
            } catch (JiraException $e) {
                $this->setJiraError($this->projectKey, 'MissingIssueException');
                throw new MissingIssueException($key);
            }
        }

        return $this->issuesCache[$key];
    }

    /**
     * Gets a list of issues that are considered bugs.
     *
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getBugs(): \JiraRestApi\Issue\IssueSearchResult
    {
        return $this->getIssues('Bug');
    }

    /**
     * Gets a list of open issues that are considered bugs.
     *
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getOpenBugs(): \JiraRestApi\Issue\IssueSearchResult
    {
        return $this->getOpenIssues('Bug');
    }

    /**
     * Methods used to submit an Issue to Jira.
     */

    /**
     * Returns the allowed types and their settings
     *
     * @param string|null $type The type of issue you want to get.
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If a type is given, and that type is not configured.
     * @return array<string, mixed> the content of $this->allowedTypes.
     */
    public function getAllowedTypes(?string $type = null): array
    {
        if ($type) {
            if (!isset($this->allowedTypes[$type])) {
                $this->setJiraError($type, 'MissingAllowedTypeException');
                throw new MissingAllowedTypeException($type);
            }

            return $this->allowedTypes[$type];
        }

        return $this->allowedTypes;
    }

    /**
     * Allows you to modify the form allowdTypes to fir your situation.
     *
     * @param string $type The type of issue you want to add/modify.
     * @param array<string, mixed> $settings The settings for the type.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueFieldException If we're adding a new issue type, and the summary field isn't defined.
     * @return void
     */
    public function modifyAllowedTypes(string $type, array $settings = []): void
    {
        if (!isset($this->allowedTypes[$type])) {
            $this->allowedTypes[$type] = [];
            if (!isset($settings['jiraType'])) {
                $this->setJiraError('jiraType', 'MissingIssueFieldException');
                throw new MissingIssueFieldException('jiraType');
            }
            if (!isset($settings['formData'])) {
                $this->setJiraError('formData', 'MissingIssueFieldException');
                throw new MissingIssueFieldException('formData');
            }
            if (!isset($settings['formData']['fields'])) {
                $this->setJiraError('formData.fields', 'MissingIssueFieldException');
                throw new MissingIssueFieldException('formData.fields');
            }
            if (!isset($settings['formData']['fields']['summary'])) {
                $this->setJiraError('formData.fields.summary', 'MissingIssueFieldException');
                throw new MissingIssueFieldException('formData.fields.summary');
            }
        }

        $this->allowedTypes[$type] += $settings;
    }

    /**
     * Checks to see if a type is allowed.
     *
     * @param string $type The type to check.
     * @return bool if it's allowed or not.
     */
    public function isAllowedType(string $type): bool
    {
        return isset($this->allowedTypes[$type]) ? true : false;
    }

    /**
     * Gets the array for the forms when submitting an issue to Jira.
     *
     * @param string|null $type The type of issue we're submitting.
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that type is not configured.
     * @throws \Fr3nch13\Jira\Exception\MissingDataException If the form data for that type is missing.
     * @return array<string, mixed> The array of data to fill in the form with.
     */
    public function getFormData(?string $type = null): array
    {
        if (!$type) {
            $this->setJiraError('[$type is not set]', 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException('[$type is not set]');
        }

        if (!$this->isAllowedType($type)) {
            $this->setJiraError($type, 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException($type);
        }

        $allowedTypes = $this->getAllowedTypes();

        if (!isset($allowedTypes[$type]['formData'])) {
            $this->setJiraError('No form data is set.', 'MissingDataException');
            throw new MissingDataException(__('No form data is set.'));
        }

        if (!isset($allowedTypes[$type]['formData']['fields'])) {
            $this->setJiraError('No form data fields are set.', 'MissingDataException');
            throw new MissingDataException(__('No form data fields are set.'));
        }

        return $allowedTypes[$type]['formData'];
    }

    /**
     * Sets the formData variable if you want to modify the default/initial values.
     *
     * @param string $type The type you want to set the data for.
     *  - Needs to be in the allowedTypes already.
     * @param array<string, mixed> $data The definition of the allowed types
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that type is not configured.
     * @throws \Fr3nch13\Jira\Exception\MissingDataException Uf the fields aren't defined.
     * @return void
     */
    public function setFormData(string $type, array $data = []): void
    {
        if (!$this->isAllowedType($type)) {
            $this->setJiraError($type, 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException($type);
        }

        if (!isset($data['fields'])) {
            $this->setJiraError('No form data fields are set.', 'MissingDataException');
            throw new MissingDataException(__('No form data fields are set.'));
        }

        $this->allowedTypes[$type]['formData'] = $data;
    }

    /**
     * Submits the Issue
     *
     * @param string $type The type you want to set the data for.
     *  - Needs to be in the allowedTypes already.
     * @param array<string, mixed> $data The array of details about the issue.
     * @throws \Fr3nch13\Jira\Exception\IssueSubmissionException If submitting the issue fails.
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that issue type is not configured.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueFieldException If we're adding a new issue, and required fields aren't defined.
     * @return int > 0 If the request was successfully submitted.
     */
    public function submitIssue(string $type, array $data = []): int
    {
        if (!$this->isAllowedType($type)) {
            $this->setJiraError($type, 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException($type);
        }

        if (!isset($data['summary'])) {
            $this->setJiraError('summary', 'MissingIssueFieldException');
            throw new MissingIssueFieldException('summary');
        }

        $issueField = $this->buildSubmittedIssue($type, $data);

        $issueService = new IssueService($this->ConfigObj);

        try {
            $ret = $issueService->create($issueField);
        } catch (JiraException $e) {
            //Sample return error with json in it.
            //Pasting here so I can mock this return message in the unit tests.
            //CURL HTTP Request Failed: Status Code : 400, URL:https://[hostname]/rest/api/2/issue
            //Error Message : {"errorMessages":[],"errors":{"user_type":"Field 'user_type' cannot be set. It is not on the appropriate screen, or unknown."}}             */
            $msg = $e->getMessage();
            if (strpos($msg, '{') !== false) {
                $msgArray = str_split($msg);
                // extract the json message.
                $json = '';
                $in = 0;
                foreach ($msgArray as $i => $char) {
                    if ($char == '{') {
                        $in++;
                    }
                    if ($in) {
                        $json .= $msg[$i];
                    }
                    if ($char == '}') {
                        $in--;
                    }
                }
                if ($json) {
                    $json = json_decode($json, true);
                }
                if ($json) {
                    $newMsg = [];
                    if (isset($json['errorMessages'])) {
                        foreach ($json['errorMessages'] as $jsonMsg) {
                            $newMsg[] = $jsonMsg;
                        }
                        foreach ($json['errors'] as $jsonMsg) {
                            $newMsg[] = $jsonMsg;
                        }
                        $msg = implode("\n", $newMsg);
                    }
                }
            }
            $this->setJiraError($msg, 'IssueSubmissionException');
            throw new IssueSubmissionException($msg);
        }

        if ($ret instanceof Issue && $ret->get('id')) {
            return (int)$ret->get('id');
        }

        return 0;
    }

    /**
     * Creates the issue to send to the server.
     *
     * @param string $type The type of isse we're creating.
     * @param array<string, mixed> $data The data from the submitted form.
     * @throws \Fr3nch13\Jira\Exception\MissingProjectException If submitting the issue fails.
     * @return \JiraRestApi\Issue\IssueField
     */
    public function buildSubmittedIssue(string $type, array $data = []): \JiraRestApi\Issue\IssueField
    {
        $typeInfo = $this->getAllowedTypes($type);

        // make sure we can get the project info first.
        // getInfo will throw an exception if it can't find the project.
        // putting a try/catch around it so scrutinizer stops complaining.
        try {
            $project = $this->getInfo();
        } catch (MissingProjectException $e) {
            $this->setJiraError($this->projectKey, 'MissingProjectException');
            throw $e;
        }

        $issueField = new IssueField();
        $issueField->setProjectKey($this->projectKey)
            ->setIssueType($typeInfo['jiraType']);

        if (isset($data['summary'])) {
            $issueField->setSummary($data['summary']);
        }
        if (isset($data['description'])) {
            $issueField->setDescription($data['description']);
        }
        if (isset($data['priority'])) {
            $issueField->setPriorityName($data['priority']);
        }
        if (isset($data['assignee'])) {
            $issueField->setAssigneeName($data['assignee']);
        }
        if (isset($data['version'])) {
            $issueField->addVersion($data['version']);
        }
        if (isset($data['components'])) {
            $issueField->addComponents($data['components']);
        }
        if (isset($data['duedate'])) {
            $issueField->setDueDate($data['duedate']);
        }

        // labels should be space seperated
        if (isset($typeInfo['jiraLabels'])) {
            if (is_string($typeInfo['jiraLabels'])) {
                $typeInfo['jiraLabels'] = preg_split('/\s+/', $typeInfo['jiraLabels']);
            }
            // track the type with a label
            $typeInfo['jiraLabels'][] = 'user-submitted-type-' . $type;
            foreach ($typeInfo['jiraLabels'] as $jiralabel) {
                $issueField->addLabel($jiralabel);
            }
        }

        return $issueField;
    }

    /**
     * Sets an error
     *
     * @param string $msg The error message.
     * @param string $key The key to use in the this->errors array.
     * @return bool If saved or not.
     */
    public function setJiraError(string $msg = '', string $key = ''): bool
    {
        if (!trim($msg)) {
            return false;
        }
        if ($key) {
            $this->errors[$key] = $msg;
        } else {
            $this->errors[] = $msg;
        }

        return true;
    }

    /**
     * Gets the accumulated error messages.
     * If a key is given, return that specific message. If that key doesn't exist, return false.
     *
     * @return array<int|string, string>
     */
    public function getJiraErrors(): array
    {
        return $this->errors;
    }
}
