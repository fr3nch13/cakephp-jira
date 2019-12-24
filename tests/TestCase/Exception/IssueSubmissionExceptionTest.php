<?php
declare(strict_types=1);

/**
 * IssueSubmissionExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\IssueSubmissionException;

/**
 * Issue Submission Exception Test
 */
class IssueSubmissionExceptionTest extends TestCase
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
            throw new IssueSubmissionException('TEST');
        } catch (IssueSubmissionException $e) {
            $this->assertEquals($e->getCode(), 500);
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
            throw new IssueSubmissionException('TEST');
        } catch (IssueSubmissionException $e) {
            $this->assertEquals($e->getMessage(), 'Problem submitting the Issue. Error(s): TEST');
        }
    }
}
