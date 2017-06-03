<?php
namespace JeremyHarris\Papertrail\Test;

use InvalidArgumentException;
use JeremyHarris\Papertrail\Logger;
use JeremyHarris\Papertrail\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    /**
     * @var Logger
     */
    private $Logger;

    /**
     * @var string
     */
    private $syslogRegexp = '/^<[\d]+>[A-Z]{3}[\s]{1,2}[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}\s(.+)/i';

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Logger = $this->getMockBuilder(Logger::class)
            ->setMethods(['writeToSocket'])
            ->getMock();
    }

    /**
     * tests log
     *
     * @return void
     */
    public function testLog()
    {
        $this->Logger
            ->expects($this->once())
            ->method('writeToSocket')
            ->with(
                $this->isType('resource'),
                $this->matchesRegularExpression($this->syslogRegexp)
            );
        $this->Logger->log(LogLevel::ALERT, 'logged');
    }

    /**
     * tests log multiple lines
     *
     * @return void
     */
    public function testLogMultipleLines()
    {
        $this->Logger
            ->expects($this->exactly(3))
            ->method('writeToSocket')
            ->with(
                $this->isType('resource'),
                $this->matchesRegularExpression($this->syslogRegexp)
            );
        $this->Logger->log(LogLevel::ALERT, "log\nmultiple\nlines");
    }

    /**
     * tests logging an invalid level
     *
     * @return void
     */
    public function testLogInvalidLevel()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->Logger
            ->expects($this->never())
            ->method('writeToSocket');

        $this->Logger->log('nope', 'logged');
    }
}
