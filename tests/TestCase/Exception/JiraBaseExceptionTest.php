<?php
declare(strict_types=1);

/**
 * JiraBaseExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\JiraBaseException;

/**
 * Jira Base Exception Test
 */
class JiraBaseExceptionTest extends TestCase
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
            throw new JiraBaseException('TEST');
        } catch (JiraBaseException $e) {
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
            throw new JiraBaseException('TEST');
        } catch (JiraBaseException $e) {
            $this->assertEquals('Jira Error(s): TEST', $e->getMessage());
        }
    }
}
