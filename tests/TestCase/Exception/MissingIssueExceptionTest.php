<?php
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
    public function testExceptionMessage()
    {
        try {
            throw new MissingIssueException('20');
        } catch (MissingIssueException $e) {
            pr($e->getMessage());
            $this->assertEquals($e->getMessage(), 'Unable to find the issue: 20');
        }
    }
}
