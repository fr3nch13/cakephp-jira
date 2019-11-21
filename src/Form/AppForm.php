<?php
/**
 * AppForm
 */

namespace Fr3nch13\Jira\Form;

use Cake\Event\EventManager;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Fr3nch13\Jira\Exception\Exception;
use Fr3nch13\Jira\Lib\JiraProject;

/**
 * App Form
 *
 * Used to submit an issue to Jira.
 */
class AppForm extends Form
{
    /**
     * Contains the loaded Jira Project object.
     *
     * @var \Fr3nch13\Jira\Lib\JiraProject|null
     */
    protected $JiraProject = null;

    /**
     * The form fields and data.
     * @var array
     */
    public $formData = [];

    /**
     * The type of issue we're submitting.
     * @var string|null
     */
    public $issueType = null;

    /**
     * Constructor
     *
     * @param \Cake\Event\EventManager|null $eventManager The event manager.
     *  Defaults to a new instance.
     * @return void
     */
    public function __construct(EventManager $eventManager = null)
    {
        parent::__construct($eventManager);

        $this->JiraProject = new JiraProject();

        $this->setFormData($this->JiraProject->getFormData($this->issueType));
    }

    /**
     * Defines the schema from the JiraProject Object.
     *
     * @param \Cake\Form\Schema $schema The existing schema.
     * @return \Cake\Form\Schema The modified schema.
     */
    protected function _buildSchema(Schema $schema)
    {
        $data = $this->getFormData();
        if (!isset($data['fields'])) {
            throw new Exception(__('Missing the fields.'));
        }
        foreach ($data['fields'] as $k => $v) {
            $schema->addField($k, $v['type']);
        }

        return $schema;
    }

    /**
     * Defines the validations
     *
     * @param \Cake\Validation\Validator $validator The existing validator.
     * @return \Cake\Validation\Validator The modified validator.
     */
    protected function _buildValidator(Validator $validator)
    {
        $data = $this->getFormData();
        if (!isset($data['fields'])) {
            throw new Exception(__('Missing the fields.'));
        }
        foreach ($data['fields'] as $k => $v) {
            if ($v['type'] == 'string') {
                $validator->scalar($k);
            }
            if ($v['type'] == 'email') {
                $validator->email($k);
            }
            if ($v['type'] == 'boolean') {
                $validator->boolean($k);
            }
        }

        return $validator;
    }

    /**
     * Submit the issue to Jira.
     *
     * @param array $data The array of post data from the form template.
     * @return bool True is the issue was submitted or false if there was an problem.
     */
    protected function _execute(array $data = [])
    {
        $data = $data + $this->getFormData();

        return $this->JiraProject->submitIssue($data); // submitIssue method doesn't exist, the _execute method should be overwritten.
    }

    /**
     * Sets the formData variable.
     *
     * @param array $data The array of data.
     * @return void
     */
    public function setFormData(array $data = [])
    {
        $this->formData = $data;
    }

    /**
     * Gets the formData variable.
     *
     * @return array The array of the current form data.
     */
    public function getFormData()
    {
        return $this->formData;
    }
}