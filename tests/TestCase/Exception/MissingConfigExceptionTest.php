<?php
declare(strict_types=1);

/**
 * MissingConfigExceptionTest
 */

namespace Fr3nch13\Jira\Test\TestCase\Exception;

use Cake\TestSuite\TestCase;
use Fr3nch13\Jira\Exception\MissingConfigException;

/**
 * Missing Config Exception Test
 */
class MissingConfigExceptionTest extends TestCase
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
            throw new MissingConfigException('TEST');
        } catch (MissingConfigException $e) {
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
            throw new MissingConfigException('host');
        } catch (MissingConfigException $e) {
            $this->assertEquals($e->getMessage(), 'Seems that the config key `Jira.host` is not set.');
        }
    }
}
