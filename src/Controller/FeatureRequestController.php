<?php

/**
 * FeatureRequestController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Controller\AppController;
use Fr3nch13\Jira\Form\FeatureRequestForm as JiraForm;

/**
 * Feature Request Controller
 *
 * Frontend for submitting feature requests to Jira.
 */

class FeatureRequestController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->humanName = __('Feature Request');
    }
}