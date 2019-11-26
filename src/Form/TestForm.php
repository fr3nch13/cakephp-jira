<?php
/**
 * TestForm
 */

namespace Fr3nch13\Jira\Form;

use Fr3nch13\Jira\Exception\Exception;
use Fr3nch13\Jira\Form\AppForm;
use Fr3nch13\Jira\Lib\JiraProject;

/**
 * Test Form
 *
 * Used to submit a Test to Jira.
 * This is mainly used for 2 reasons.
 * - An example of how to add another type othen than a Bug or FeatureRequest.
 * - Used by the unit tests to make sure a non-standard type is still working.
 */
class TestForm extends AppForm
{
    /**
     * Constructor
     *
     * @param \Cake\Event\EventManager|null $eventManager The event manager.
     *  Defaults to a new instance.
     * @return void
     */
    public function __construct(EventManager $eventManager = null)
    {
        $this->issueType = 'Test';

        $this->settings = [
            'type' => 'Task', // Jira issue type
            'labels' => 'test-label', // any labels that you want that issue tagged with. space seperated.
            // data used in this form.
            'formData' => [
                // define the fields here for the HtmlHelper::control()
                'fields' => [
                    'name' => [
                        'type' => 'string',
                        'required' => true
                    ]
                ]
            ]
        ];

        parent::__construct($eventManager);
    }
}
