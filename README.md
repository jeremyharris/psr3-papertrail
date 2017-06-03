[![Build Status](https://travis-ci.org/jeremyharris/psr3-papertrail.svg?branch=master)](https://travis-ci.org/jeremyharris/psr3-papertrail)

# PSR-3 Papertrail Logger

This is a [PSR-3][1] compatible logger that logs to [Papertrail][2].

## Installation

```
composer require jeremyharris/psr3-papertrail
```

To log to Papertrail, you must define the following constants with your Papertrail
credentials:

- `PAPERTRAIL_HOST`: Your Papertrail host
- `PAPERTRAIL_PORT`: Your Papertrail port

## Usage

```php
define('PAPERTRAIL_HOST', 'example.papertrailapp.com');
define('PAPERTRAIL_PORT', 1234);

$logger = new \JeremyHarris\Papertrail\Logger;
$logger->log('error', 'An error occured');
```

For more information about PSR-3 logging, visit the [PSR-3 recommendation][1].
This package contains the `\Psr\Log\LogLevel` class for friendly log level
constants.

**Note:** Logs are transported over UDP and are therefore fast but fail silently.

### Context Options

While no context options are required, you can pass a program and hostname to
manually define them.

- `string $program`: Program to use. Uses `'logger'` by default.
- `string $hostname`: Hostname to use. Uses `gethostname()` by default
- `string $facility`: Facility to use. Uses local0 (16) by default. See [RFC 3164][3] for details


[1]: http://www.php-fig.org/psr/psr-3/
[2]: https://papertrailapp.com
[3]: https://tools.ietf.org/html/rfc3164