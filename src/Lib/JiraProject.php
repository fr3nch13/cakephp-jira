<?php
/**
 * JiraProjectReader
 */

namespace Fr3nch13\Jira\Lib;

use Cake\Core\Configure;
use Fr3nch13\Jira\Exception\Exception;
use Fr3nch13\Jira\Exception\IssueSubmissionException;
use Fr3nch13\Jira\Exception\MissingAllowedTypeException;
use Fr3nch13\Jira\Exception\MissingConfigException;
use Fr3nch13\Jira\Exception\MissingIssueException;
use Fr3nch13\Jira\Exception\MissingIssueFieldException;
use Fr3nch13\Jira\Exception\MissingProjectException;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueField;
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
     * @var \JiraRestApi\Configuration\ArrayConfiguration
     */
    public $ConfigObj;

    /**
     * The key for the project.
     * @var string|null
     */
    public $projectKey = null;

    /**
     * The project service object.
     * @var \JiraRestApi\Project\ProjectService
     */
    public $ProjectService;

    /**
     * The project object.
     * @var \JiraRestApi\Project\Project
     */
    protected $Project;

    /**
     * The list of a Project's Versions.
     * @var \ArrayObject|\JiraRestApi\Issue\Version[]
     */
    protected $Versions;

    /**
     * The project service object.
     * @var \JiraRestApi\Issue\IssueService
     */
    public $IssueService;

    /**
     * The Cached list of issues.
     * @var array
     */
    protected $Issues = [];

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
                    ]
                ]
            ]
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
                    ]
                ]
            ]
        ]
    ];

    /**
     * This is here for the Form object (or any other object) to use.
     * It tacks all errors, even if an exception is thrown.
     * @var array
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
        } catch (\JiraRestApi\JiraException $e) {
            $this->setError($this->projectKey, 'MissingProjectException');
            throw new MissingProjectException($this->projectKey);
        }

        $this->Versions = $this->ProjectService->getVersions($this->projectKey);
        $this->IssueService = new IssueService($this->ConfigObj);
    }

    /**
     * Configures the object.
     * Broken out of construct.
     *
     * @throws \Fr3nch13\Jira\Exception\MissingConfigException When a config setting isn't set.
     * @return void
     */
    public function configure()
    {
        $schema = Configure::read('Jira.schema');
        if (!$schema) {
            $this->setError('schema', 'MissingConfigException');
            throw new MissingConfigException('schema');
        }
        $host = Configure::read('Jira.host');
        if (!$host) {
            $this->setError('host', 'MissingConfigException');
            throw new MissingConfigException('host');
        }
        $username = Configure::read('Jira.username');
        if (!$username) {
            $this->setError('username', 'MissingConfigException');
            throw new MissingConfigException('username');
        }
        $apiKey = Configure::read('Jira.apiKey');
        if (!$apiKey) {
            $this->setError('apiKey', 'MissingConfigException');
            throw new MissingConfigException('apiKey');
        }
        $projectKey = Configure::read('Jira.projectKey');
        if (!$projectKey) {
            $this->setError('projectKey', 'MissingConfigException');
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
        return $this->Project;
    }

    /**
     * Get the Project's Versions.
     *
     * @return \ArrayObject|\JiraRestApi\Issue\Version[] A list of version objects.
     */
    public function getVersions()
    {
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

            $this->Issues[$cacheKey] = $this->IssueService->search($jql->getQuery(), 0, 1000);
        }

        return $this->Issues[$cacheKey];
    }

    /**
     * Gets info on a particular issue within your project.
     *
     * @param int|null $id The issue id. The integer part without the project key.
     * @return \JiraRestApi\Issue\Issue|\JiraRestApi\Issue\IssueV3 the object that has the info of that issue.
     * @throws \Fr3nch13\Jira\Exception\Exception If the issue's id isn't given.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueException If the project's issue can't be found.
     */
    public function getIssue($id = null)
    {
        if (!is_int($id)) {
            $this->setError(__('Missing the Issue\'s ID.'), 'Exception');
            throw new Exception(__('Missing the Issue\'s ID.'));
        }
        $key = $this->projectKey . '-' . $id;
        if (!isset($this->issuesCache[$key])) {
            if (!$this->issuesCache[$key] = $this->IssueService->get($key)) {
                $this->setError($key, 'MissingIssueException');
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
     * Returns the allowed types and their settings
     *
     * @param string|null $type The type of issue you want to get.
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If a type is given, and that type is not configured.
     * @return array the content of $this->allowedTypes.
     */
    public function getAllowedTypes($type = null)
    {
        if ($type) {
            if (!isset($this->allowedTypes[$type])) {
                $this->setError($type, 'MissingAllowedTypeException');
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
     * @param array $settings The settings for the type.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueFieldException If we're adding a new issue type, and the summary field isn't defined.
     * @return void
     */
    public function modifyAllowedTypes($type, $settings = [])
    {
        if (!isset($this->allowedTypes[$type])) {
            $this->allowedTypes[$type] = [];
            if (!isset($settings['jiraType'])) {
                $this->setError('jiraType', 'MissingIssueFieldException');
                throw new MissingIssueFieldException('jiraType');
            }
            if (!isset($settings['formData'])) {
                $this->setError('formData', 'MissingIssueFieldException');
                throw new MissingIssueFieldException('formData');
            }
            if (!isset($settings['formData']['fields'])) {
                $this->setError('formData.fields', 'MissingIssueFieldException');
                throw new MissingIssueFieldException('formData.fields');
            }
            if (!isset($settings['formData']['fields']['summary'])) {
                $this->setError('formData.fields.summary', 'MissingIssueFieldException');
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
    public function isAllowedType($type)
    {
        return (isset($this->allowedTypes[$type]) ? true : false);
    }

    /**
     * Gets the array for the forms when submitting an issue to Jira.
     *
     * @param string|null $type The type of issue we're submitting.
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that type is not configured.
     * @throws \Fr3nch13\Jira\Exception\Exception If the form data for that type is missing.
     * @return array The array of data to fill in the form with.
     */
    public function getFormData($type = null)
    {
        if (!$type) {
            $this->setError('[$type is not set]', 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException('[$type is not set]');
        }

        if (!$this->isAllowedType($type)) {
            $this->setError($type, 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException($type);
        }

        $allowedTypes = $this->getAllowedTypes();

        if (!isset($allowedTypes[$type]['formData'])) {
            $this->setError('No form data is set.', 'Exception');
            throw new Exception(__('No form data is set.'));
        }

        return $allowedTypes[$type]['formData'];
    }

    /**
     * Sets the formData variable if you want to modify the default/initial values.
     *
     * @param string $type The type you want to set the data for.
     *  - Needs to be in the allowedTypes already.
     * @param array $data The definition of the allowed types
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that type is not configured.
     * @return void
     */
    public function setFormData($type, $data = [])
    {
        if (!$type) {
            $this->setError('[$type is not set]', 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException('[$type is not set]');
        }

        if (!$this->isAllowedType($type)) {
            $this->setError($type, 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException($type);
        }

        $this->allowedTypes[$type]['formData'] = $data;
    }

    /**
     * Submits the Issue
     *
     * @param string $type The type you want to set the data for.
     *  - Needs to be in the allowedTypes already.
     * @param array $data The array of details about the issue.
     * @throws \Fr3nch13\Jira\Exception\IssueSubmissionException If submitting the issue fails.
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that issue type is not configured.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueFieldException If we're adding a new issue, and required fields aren't defined.
     * @return int|bool If the request was successfully submitted.
     */
    public function submitIssue($type, array $data = [])
    {
        if (!$type) {
            $this->setError('[$type is not set]', 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException('[$type is not set]');
        }

        if (!$this->isAllowedType($type)) {
            $this->setError($type, 'MissingAllowedTypeException');
            throw new MissingAllowedTypeException($type);
        }

        if (!isset($data['summary'])) {
            $this->setError('summary', 'MissingIssueFieldException');
            throw new MissingIssueFieldException('summary');
        }

        $typeInfo = $this->getAllowedTypes($type);

        // make sure we can get the project info first.
        // getInfo will throw an exception if it can't find the project.
        // putting a try/catch around it so scrutinizer stops complaining.
        try {
            $project = $this->getInfo();
        } catch (MissingProjectException $e) {
            $this->setError($this->projectKey, 'MissingProjectException');
            throw $e;
        }

        $issueField = new IssueField();
        $issueField->setProjectKey($this->projectKey)
            ->setIssueType($typeInfo['jiraType']);

        /*
         * Yes, I know I'm not validating the input here.
         * I'm relying on the underlying IssueField to validate the data.
         */

        // I know i'm checking above, so this really isn't needed, but keeping here for consistancy/readability.
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
            $issueField->setPriorityName($data['assignee']);
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

        $issueService = new IssueService($this->ConfigObj);

        try {
            $ret = $issueService->create($issueField);
        } catch (\JiraRestApi\JiraException $e) {
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
            $this->setError($msg, 'IssueSubmissionException');
            throw new IssueSubmissionException($msg);
        }

        if ($ret instanceof \JiraRestApi\Issue\Issue && $ret->id) {
            return (int)$ret->id;
        }

        return true;
    }

    /**
     * Sets an error
     *
     * @param string $msg The error message.
     * @param string $key The key to use in the this->errors array.
     * @return bool If saved or not.
     */
    public function setError($msg = '', $key = '')
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
     * @param string|null $key The key to the specific message to get.
     * @return array|string|false
     */
    public function getErrors($key = null)
    {
        if ($key) {
            if (isset($this->errors[$key])) {
                return $this->errors[$key];
            } else {
                return false;
            }
        }

        return $this->errors;
    }
}
