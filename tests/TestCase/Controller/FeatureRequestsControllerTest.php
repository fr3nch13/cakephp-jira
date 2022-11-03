<?php
declare(strict_types=1);

/**
 * FeatureRequestsControllerTest
 */

namespace Fr3nch\Jira\Test\TestCase\Controller;

/**
 * Feature Requests Controller Test
 */
class FeatureRequestsControllerTest extends AppControllerTest
{
    /**
     * @var string The controller name
     */
    public $controller = 'feature-requests';

    /**
     * @var string The type of issue to submit to Jira.
     */
    public $type = 'Feature Request';
}
