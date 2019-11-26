<?php
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
    public function testExceptionMessage()
    {
        try {
            throw new MissingConfigException('host');
        } catch (MissingConfigException $e) {
            pr($e->getMessage());
            $this->assertEquals($e->getMessage(), 'Seems that the config key `Jira.host` is not set.');
        }
    }
}
