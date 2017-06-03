<?php
namespace JeremyHarris\Papertrail\Test;

use InvalidArgumentException;
use JeremyHarris\Papertrail\LogLevel;
use PHPUnit\Framework\TestCase;

class LogLevelTest extends TestCase
{
    /**
     * tests isValidLevel
     *
     * @return void
     */
    public function testIsValidLevel()
    {
        $logLevel = new LogLevel();
        $this->assertTrue($logLevel->isValidLevel('warning'));
        $this->assertFalse($logLevel->isValidLevel('nope'));
    }

    /**
     * tests levelToNumericCode
     *
     * @return void
     */
    public function testLevelToNumericCode()
    {
        $logLevel = new LogLevel();
        $this->assertSame(LOG_ERR, $logLevel->levelToNumericCode('error'));
    }

    /**
     * tests trying to convert an invalid level
     *
     * @return void
     */
    public function testLevelToNumericCodeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $logLevel = new LogLevel();
        $logLevel->levelToNumericCode('nope');
    }
}
