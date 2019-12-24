<?php
declare(strict_types=1);

/**
 * MissingAllowedTypeExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingAllowedTypeException;

/**
 * Missing Allowed Type Exception Test
 */
class MissingAllowedTypeExceptionTest extends TestCase
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
            throw new MissingAllowedTypeException('TEST');
        } catch (MissingAllowedTypeException $e) {
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
            throw new MissingAllowedTypeException('TEST');
        } catch (MissingAllowedTypeException $e) {
            $this->assertEquals($e->getMessage(), 'Unknown Allowed Type: TEST');
        }
    }
}
