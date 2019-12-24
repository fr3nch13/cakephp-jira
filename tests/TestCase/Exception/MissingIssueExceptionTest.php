<?php
declare(strict_types=1);

/**
 * MissingIssueExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingIssueException;

/**
 * Missing Issue Exception Test
 */
class MissingIssueExceptionTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * testBootstrap
     *
     * @return void
     */
    public function testExceptionCode(): void
    {
        try {
            throw new MissingIssueException('TEST');
        } catch (MissingIssueException $e) {
            $this->assertEquals($e->getCode(), 404);
        }
    }

    /**
     * testConsole
     *
     * @return void
     */
    public function testExceptionMessage(): void
    {
        try {
            throw new MissingIssueException('20');
        } catch (MissingIssueException $e) {
            $this->assertEquals($e->getMessage(), 'Unable to find the issue: 20');
        }
    }
}
