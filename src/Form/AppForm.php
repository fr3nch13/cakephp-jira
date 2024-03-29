<?php
declare(strict_types=1);

/**
 * AppForm
 */

namespace Fr3nch13\Jira\Form;

use Cake\Event\EventManager;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Fr3nch13\Jira\Exception\JiraBaseException;
use Fr3nch13\Jira\Exception\MissingDataException;
use Fr3nch13\Jira\Lib\JiraProject;

/**
 * App Form
 *
 * Used to submit an issue to Jira.
 */
class AppForm extends Form
{
    /**
     * @var \Fr3nch13\Jira\Lib\JiraProject Contains the loaded Jira Project object.
     */
    protected $JiraProject;

    /**
     * @var string The type of issue we're submitting.
     */
    public $issueType = 'Task';

    /**
     * @var array<string, mixed> Settings for this form and for the JiraProject.
     */
    public $settings = [];

    /**
     * Constructor
     *
     * @param \Cake\Event\EventManager|null $eventManager The event manager.
     *  Defaults to a new instance.
     */
    public function __construct(?EventManager $eventManager = null)
    {
        if ($eventManager !== null) {
            parent::__construct($eventManager);
        }
        $this->JiraProject = new JiraProject();

        if (!empty($this->settings)) {
            $this->JiraProject->modifyAllowedTypes($this->issueType, $this->settings);
        }

        $formData = $this->getFormData();
        $this->setFormData($formData);
    }

    /**
     * Defines the schema from the JiraProject Object.
     *
     * @param \Cake\Form\Schema $schema The existing schema.
     * @throws \Fr3nch13\Jira\Exception\MissingDataException If the issue's id isn't given.
     * @return \Cake\Form\Schema The modified schema.
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        $data = $this->getFormData();
        if (!isset($data['fields'])) {
            throw new MissingDataException(__('Missing the fields.'));
        }
        foreach ($data['fields'] as $k => $v) {
            $schema->addField($k, $v);
        }

        return $schema;
    }

    /**
     * Defines the validations
     *
     * @param \Cake\Validation\Validator $validator The existing validator.
     * @throws \Fr3nch13\Jira\Exception\MissingDataException If the issue's id isn't given.
     * @return \Cake\Validation\Validator The modified validator.
     */
    public function validationDefault(Validator $validator): Validator
    {
        $data = $this->getFormData();
        if (!isset($data['fields'])) {
            throw new MissingDataException(__('Missing the fields.'));
        }
        foreach ($data['fields'] as $k => $v) {
            if ($v['type'] == 'string' || $v['type'] == 'text') {
                $validator->scalar($k);
            }
            if ($v['type'] == 'email') {
                $validator->email($k);
            }
            if ($v['type'] == 'boolean') {
                $validator->boolean($k);
            }
            if (isset($v['required']) && $v['required'] === true) {
                $validator->requirePresence($k);
            }
        }

        return $validator;
    }

    /**
     * Submit the issue to Jira.
     *
     * @param array<string, mixed> $data The array of post data from the form template.
     * @return bool True is the issue was submitted or false if there was an problem.
     */
    protected function _execute(array $data = []): bool
    {
        try {
            $result = $this->JiraProject->submitIssue($this->issueType, $data);
        } catch (JiraBaseException $e) {
            $errors = $this->JiraProject->getJiraErrors();
            foreach ($errors as $k => $v) {
                // track the errors specific to jira/the JiraProject object.
                $this->setErrors(['jira' => [$k => $v]]);
            }

            return false;
        }

        if ($result > 0) {
            return true;
        }

        return false;
    }

    /**
     * Sets the formData variable.
     *
     * @param array<string, mixed> $data The array of data.
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that type is not configured.
     * @throws \Fr3nch13\Jira\Exception\MissingDataException Uf the fields aren't defined.
     * @return void
     */
    public function setFormData(array $data = []): void
    {
        $this->JiraProject->setFormData($this->issueType, $data);
    }

    /**
     * Gets the formData variable.
     *
     * @throws \Fr3nch13\Jira\Exception\MissingAllowedTypeException If that type is not configured.
     * @throws \Fr3nch13\Jira\Exception\MissingDataException If the form data for that type is missing.
     * @return array<string, mixed> The array of the current form data.
     */
    public function getFormData(): array
    {
        return $this->JiraProject->getFormData($this->issueType);
    }
}
