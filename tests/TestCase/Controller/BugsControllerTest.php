<?php
declare(strict_types=1);

/**
 * BugsControllerTest
 */

namespace Fr3nch\Jira\Test\TestCase\Controller;

/**
 * Bugs Controller Test
 */
class BugsControllerTest extends AppControllerTest
{
    /**
     * @var string The controller name
     */
    public $controller = 'bugs';

    /**
     * @var string The type of issue to submit to Jira.
     */
    public $type = 'Bug Report';
}
