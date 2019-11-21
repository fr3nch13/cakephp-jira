<?php

/**
 * BugController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Controller\AppController;
use Fr3nch13\Jira\Form\BugForm;

/**
 * Bug Controller
 *
 * Frontend for submitting bugs to Jira.
 */

class BugController extends AppController
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
        $this->JiraForm = new BugForm();
    }

    /**
     * The form
     *
     * {@inheritdoc}
     */
    public function index()
    {
        parent::index();
    }
}
