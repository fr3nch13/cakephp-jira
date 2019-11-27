<?php
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
    public function testExceptionMessage()
    {
        try {
            throw new MissingIssueFieldException('test');
        } catch (MissingIssueFieldException $e) {
            $this->assertEquals($e->getMessage(), 'Missing the issue field: test');
        }
    }
}
