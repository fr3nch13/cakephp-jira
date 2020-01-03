<?php

/**
 * TestsController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Controller\AppController;
use Fr3nch13\Jira\Form\TestForm;

/**
 * Tests Controller
 *
 * Frontend for submitting bugs to Jira.
 *
 * @property \Fr3nch13\Jira\Form\TestForm $JiraForm
 */

class TestsController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->humanName = __('Test');
        $this->JiraForm = new TestForm();
    }
}
