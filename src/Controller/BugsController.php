<?php
declare(strict_types=1);

/**
 * BugsController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Form\BugForm as JiraForm;

/**
 * Bugs Controller
 *
 * Frontend for submitting bugs to Jira.
 */

class BugsController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->humanName = __('Bug');
        $this->JiraForm = new JiraForm();
    }
}
