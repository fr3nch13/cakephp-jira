<?php
declare(strict_types=1);

/**
 * MissingDataExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingDataException;

/**
 * Missing Data Exception Test
 */
class MissingDataExceptionTest extends TestCase
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
            throw new MissingDataException('TEST');
        } catch (MissingDataException $e) {
            $this->assertEquals(500, $e->getCode());
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
            throw new MissingDataException('fields');
        } catch (MissingDataException $e) {
            $this->assertEquals('Missing Data: fields', $e->getMessage());
        }
    }
}
