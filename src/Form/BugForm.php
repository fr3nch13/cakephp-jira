<?php
/**
 * BugForm
 */

namespace Fr3nch13\Jira\Form;

use Cake\Event\EventManager;
use Fr3nch13\Jira\Exception\Exception;
use Fr3nch13\Jira\Form\AppForm;
use Fr3nch13\Jira\Lib\JiraProject;

/**
 * Bug Form
 *
 * Used to submit a bug to Jira.
 */
class BugForm extends AppForm
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
        $this->issueType = 'Bug';

        parent::__construct($eventManager);
    }
}
