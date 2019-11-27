<?php
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
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * testBootstrap
     *
     * @return void
     */
    public function testExceptionCode()
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
    public function testExceptionMessage()
    {
        try {
            throw new IssueSubmissionException('TEST');
        } catch (IssueSubmissionException $e) {
            $this->assertEquals($e->getMessage(), 'Problem submitting the Issue. Error(s): TEST');
        }
    }
}
