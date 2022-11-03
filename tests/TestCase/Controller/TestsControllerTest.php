<?php
declare(strict_types=1);

/**
 * TestsControllerTest
 */

namespace Fr3nch\Jira\Test\TestCase\Controller;

/**
 * Tests Controller Test
 */
class TestsControllerTest extends AppControllerTest
{
    /**
     * @var string The controller name
     */
    public $controller = 'tests';

    /**
     * @var string The type of issue to submit to Jira.
     */
    public $type = 'Test';
}
