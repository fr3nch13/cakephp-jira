<?php
declare(strict_types=1);

/**
 * TestForm
 */

namespace Fr3nch13\Jira\Form;

use Cake\Event\EventManager;

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
    public function __construct(?EventManager $eventManager = null)
    {
        $this->issueType = 'Test';

        $this->settings = [
            // a valid Jira issue type
            'jiraType' => 'Task',
            // any labels that you want that issue tagged with. space seperated string, or an array.
            'jiraLabels' => 'test-label',
            // data used in this form.
            'formData' => [
                // define the fields here for the HtmlHelper::control()
                'fields' => [
                    // this is really the only required field.
                    'summary' => [
                        'type' => 'string',
                        'required' => true,
                    ],
                    // add more fields here, like description, etc.
                    'details' => [
                        'type' => 'textarea',
                        'required' => true,
                    ],
                ],
            ],
        ];

        parent::__construct($eventManager);
    }
}
