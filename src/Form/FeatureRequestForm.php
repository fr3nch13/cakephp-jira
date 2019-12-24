<?php
declare(strict_types=1);

/**
 * FeatureRequestForm
 */

namespace Fr3nch13\Jira\Form;

use Cake\Event\EventManager;

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
    public function __construct(?EventManager $eventManager = null)
    {
        $this->issueType = 'FeatureRequest';

        parent::__construct($eventManager);
    }
}
