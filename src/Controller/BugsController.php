<?php

/**
 * BugsController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Controller\AppController;
use Fr3nch13\Jira\Form\BugForm as JiraForm;

/**
 * Bug Controller
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
    public function initialize()
    {
        parent::initialize();

        $this->humanName = __('Bug');
        $this->JiraForm = new JiraForm();
    }
}
