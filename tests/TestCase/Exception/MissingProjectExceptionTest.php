<?php
declare(strict_types=1);

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
    public function testExceptionMessage(): void
    {
        try {
            throw new MissingProjectException('TEST');
        } catch (MissingProjectException $e) {
            $this->assertEquals($e->getMessage(), 'Unable to find the project: TEST');
        }
    }
}
