<?php
declare(strict_types=1);

/**
 * TestsController
 */

namespace Fr3nch13\Jira\Controller;

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
    public function initialize(): void
    {
        parent::initialize();

        $this->humanName = __('Test Report');
        $this->JiraForm = new JiraForm();
    }
}
