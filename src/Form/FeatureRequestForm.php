<?php
/**
 * FeatureRequestForm
 */

namespace Fr3nch13\Jira\Form;

use Fr3nch13\Jira\Exception\Exception;
use Fr3nch13\Jira\Form\AppForm;
use Fr3nch13\Jira\Lib\JiraProject;

/**
 * Feature Request Form
 *
 * Used to submit a feature request to Jira.
 */
class FeatureRequestForm extends AppForm
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
        $this->issueType = 'FeatureRequest';

        parent::__construct($eventManager);
    }
}
