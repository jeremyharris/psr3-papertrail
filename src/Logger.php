<?php
namespace JeremyHarris\Papertrail;

use InvalidArgumentException;
use JeremyHarris\Papertrail\LogLevel;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{

    /**
     * Log a message to Papertrail
     *
     * @param string $level Level
     * @param string $message Message
     * @param array $context Context
     * @see https://tools.ietf.org/html/rfc3164
     */
    public function log($level, $message, array $context = [])
    {
        $logLevel = new LogLevel();

        $context += [
            // use local0 by default; see RFC for facility definitions
            'facility' => 16,
            'hostname' => gethostname(),
            'program' => 'logger'
        ];

        if (!$logLevel->isValidLevel($level)) {
            throw new InvalidArgumentException('Invalid log level.');
        }

        $severity = $logLevel->levelToNumericCode($level);
        $priority = ($context['facility'] * 8) + $severity;

        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $lines = explode(PHP_EOL, $message);
        foreach ($lines as $line) {
            $dayPart = date('j');
            if (strlen($dayPart) === 1) {
                $dayPart = ' ' . $dayPart;
            }
            $date = date("M $dayPart H:i:s");

            $syslogMessage = "<$priority>$date {$context['hostname']} {$context['program']} {$line}";
            $this->writeToSocket($socket, $syslogMessage);
        }
        socket_close($socket);
    }

    /**
     * Writes to the socket
     *
     * @param resource $socket Socket
     * @param string $message Message
     */
    protected function writeToSocket($socket, $message)
    {
        socket_sendto($socket, $message, strlen($message), 0, PAPERTRAIL_HOST, PAPERTRAIL_PORT);
    }
}
