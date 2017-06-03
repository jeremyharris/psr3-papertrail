<?php
namespace JeremyHarris\Papertrail;

use InvalidArgumentException;
use Psr\Log\LogLevel as PsrLogLevel;

class LogLevel extends PsrLogLevel
{

    /**
     * Map for log levels to their numeric equivalent
     *
     * @var array
     */
    private $levelMap = [
        'alert' => LOG_ALERT,
        'critical' => LOG_CRIT,
        'debug' => LOG_DEBUG,
        'emergency' => LOG_EMERG,
        'error' => LOG_ERR,
        'info' => LOG_INFO,
        'notice' => LOG_NOTICE,
        'warning' => LOG_WARNING,
    ];

    /**
     * Checks if $level is a valid log level
     *
     * @param string $level Level
     * @return bool
     */
    public function isValidLevel($level)
    {
        return array_key_exists($level, $this->levelMap);
    }

    /**
     * Converts log level to its numeric code
     *
     * @param string $level Level
     * @return int
     * @throws InvalidArgumentException
     */
    public function levelToNumericCode($level)
    {
        if (!$this->isValidLevel($level)) {
            throw new InvalidArgumentException('Level does not exist.');
        }
        return $this->levelMap[$level];
    }
}
