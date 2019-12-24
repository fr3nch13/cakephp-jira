<?php
declare(strict_types=1);

/**
 * MissingIssueFieldExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingIssueFieldException;

/**
 * Missing Issue Exception Test
 */
class MissingIssueFieldExceptionTest extends TestCase
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
            throw new MissingIssueFieldException('TEST');
        } catch (MissingIssueFieldException $e) {
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
            throw new MissingIssueFieldException('test');
        } catch (MissingIssueFieldException $e) {
            $this->assertEquals($e->getMessage(), 'Missing the issue field: test');
        }
    }
}
