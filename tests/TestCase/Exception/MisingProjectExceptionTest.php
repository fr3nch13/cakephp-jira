<?php
/**
 * MissingProjectExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingProjectException;

/**
 * Missing Project Exception Test
 */
class MissingProjectExceptionTest extends TestCase
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
            throw new MissingProjectException('TEST');
        } catch (MissingProjectException $e) {
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
            throw new MissingProjectException('TEST');
        } catch (MissingProjectException $e) {
            $this->assertEquals($e->getMessage(), 'Unable to find the project: TEST');
        }
    }
}
