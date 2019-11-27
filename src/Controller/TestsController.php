<?php

/**
 * TestsController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Controller\AppController;
use Fr3nch13\Jira\Form\TestForm as JiraForm;

/**
 * Tests Controller
 *
 * Frontend for submitting bugs to Jira.
 */

class TestsController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->humanName = __('Test');
        $this->JiraForm = new JiraForm();
    }
}
