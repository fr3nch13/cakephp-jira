<?php
declare(strict_types=1);

/**
 * FeatureRequestsController
 */

namespace Fr3nch13\Jira\Controller;

use Fr3nch13\Jira\Form\FeatureRequestForm as JiraForm;

/**
 * Feature Requests Controller
 *
 * Frontend for submitting feature requests to Jira.
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
        $this->JiraForm = new JiraForm();
    }
}
