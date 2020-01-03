<?php

/**
 * FeatureRequestsController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Controller\AppController;
use Fr3nch13\Jira\Form\FeatureRequestForm;

/**
 * Feature Requests Controller
 *
 * Frontend for submitting feature requests to Jira.
 *
 * @property \Fr3nch13\Jira\Form\FeatureRequestForm $JiraForm
 */

class FeatureRequestsController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->humanName = __('Feature Request');
        $this->JiraForm = new FeatureRequestForm();
    }
}
