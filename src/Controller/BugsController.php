<?php

/**
 * BugsController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Controller\AppController;
use Fr3nch13\Jira\Form\BugForm;

/**
 * Bugs Controller
 *
 * Frontend for submitting bugs to Jira.
 *
 * @property \Fr3nch13\Jira\Form\BugForm $JiraForm
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
        $this->JiraForm = new BugForm();
    }
}
