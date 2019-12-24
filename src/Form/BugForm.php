<?php
declare(strict_types=1);

/**
 * BugForm
 */

namespace Fr3nch13\Jira\Form;

use Cake\Event\EventManager;

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
    public function __construct(?EventManager $eventManager = null)
    {
        $this->issueType = 'Bug';

        parent::__construct($eventManager);
    }
}
