## Overview

This repository uses **CodeIgniter 4's built-in logging system**, which implements the **PSR-3 LoggerInterface** standard. The logging framework provides structured, level-based logging with file-based output as the primary sink.

## Architecture and Components

### Core Framework (system/Log/)

The logging system consists of three main layers:

1. **Logger class** (`system/Log/Logger.php`) - Implements `Psr\Log\LoggerInterface` and provides all eight PSR-3 log levels: `emergency`, `alert`, `critical`, `error`, `warning`, `notice`, `info`, `debug`

2. **Handler Interface** (`system/Log/Handlers/HandlerInterface.php`) - Defines the contract for log handlers with methods: `handle()`, `canHandle()`, `setDateFormat()`

3. **Available Handlers** (`system/Log/Handlers/`):
   - `FileHandler.php` - **Active handler**; writes logs to dated files in `writable/logs/`
   - `ChromeLoggerHandler.php` - Available but commented out; for browser console integration
   - `ErrorlogHandler.php` - Available but commented out; routes to PHP's native `error_log()`
   - `BaseHandler.php` - Abstract base class providing common functionality

### Configuration (`app/Config/Logger.php`)

**Log Level Threshold:**
- Production environment: threshold `4` (logs error and above: emergency, alert, critical, error)
- Non-production environments: threshold `9` (logs all levels including debug)

**Active Handler Configuration:**
```php
FileHandler::class => [
    'handles' => ['critical', 'alert', 'emergency', 'debug', 'error', 'info', 'notice', 'warning'],
    'fileExtension' => '',  // defaults to 'log'
    'filePermissions' => 0644,
    'path' => '',  // defaults to WRITEPATH . 'logs/'
]
```

**Date Format:** `'Y-m-d H:i:s'` (configurable via `$dateFormat`)

### Log Output Format

Logs are written to daily rotating files with the pattern: `log-{YYYY-MM-DD}.log`

Each log entry follows this format:
```
{LEVEL_UPPERCASE} - {timestamp} --> {message}
```

Example:
```
ERROR - 2024-01-15 14:30:22 --> Database connection failed APPPATH/Models/UserModel.php:45
```

### Message Interpolation

The Logger supports placeholder interpolation in messages using `{key}` syntax. Special placeholders include:
- `{file}` and `{line}` - Automatically resolved from call stack
- `{env}` - Current environment name
- `{env:VAR_NAME}` - Specific environment variable
- `{post_vars}`, `{get_vars}`, `{session_vars}` - Superglobal arrays
- `{exception}` - Exception message with file and line when Throwable is passed in context

## Integration Points

### Service Registration

The logger is registered as a shared service in `system/Config/Services.php`:
```php
public static function logger(bool $getShared = true)
{
    if ($getShared) {
        return static::getSharedInstance('logger');
    }
    return new Logger(config(LoggerConfig::class));
}
```

### Global Helper Function

The `log_message()` function in `system/Common.php` provides convenient access:
```php
log_message(string $level, string $message, array $context = []): void
```

In testing environments, this automatically uses `TestLogger` for assertion support.

### Exception Logging

Exception handling is configured in `app/Config/Exceptions.php`:
- `$log = true` - Exceptions are automatically logged through the logging service
- `$ignoreCodes = [404]` - Page not found errors are excluded from logging
- `$logDeprecations = true` - Deprecated errors are logged at WARNING level
- `$deprecationLogLevel = LogLevel::WARNING` - Configurable deprecation log level

The exception handler (`system/Debug/ExceptionHandler.php`) renders error views but does not directly write to logs; logging occurs through the configured exception config.

### Debug Toolbar Integration

When `CI_DEBUG` is enabled, the Logger caches log entries in `$logCache` property for display in CodeIgniter's Debug Toolbar.

## Key Files

- `app/Config/Logger.php` - Application-specific logger configuration
- `app/Config/Exceptions.php` - Exception-to-logging integration settings
- `system/Log/Logger.php` - Core PSR-3 Logger implementation
- `system/Log/Handlers/FileHandler.php` - Active file-based log handler
- `system/Log/Handlers/HandlerInterface.php` - Handler interface contract
- `system/Common.php` - Contains `log_message()` helper function (lines 789-819)
- `system/Config/Services.php` - Logger service registration (around line 398-406)
- `writable/logs/` - Runtime log file directory

## Developer Conventions

### Usage Patterns

1. **Use the global helper** for simple logging:
   ```php
   log_message('error', 'Something went wrong');
   log_message('info', 'User logged in', ['user_id' => $userId]);
   ```

2. **Access via service** for dependency injection scenarios:
   ```php
   $logger = service('logger');
   $logger->error('Database query failed', ['query' => $sql]);
   ```

3. **Include context data** for structured debugging:
   ```php
   log_message('error', 'Payment processing failed', [
       'order_id' => $orderId,
       'amount' => $amount,
       'exception' => $exception  // Automatically formats with file:line
   ]);
   ```

### Log Level Guidelines

Based on the framework's documented semantics:
- **emergency/alert/critical** - System failures requiring immediate attention
- **error** - Runtime errors that should be monitored (production default threshold)
- **warning** - Exceptional but non-error conditions (deprecated APIs, poor usage patterns)
- **notice/info** - Significant events (user actions, SQL queries)
- **debug** - Detailed diagnostic information (development only)

### Important Constraints

1. **No custom handlers defined** - The application uses only the default FileHandler; ChromeLogger and Errorlog handlers remain commented out in configuration

2. **No application-level overrides** - `app/Config/Services.php` contains no custom logger service override; relies entirely on framework defaults

3. **No structured JSON logging** - Log output is plain text format, not JSON or other structured formats

4. **Daily log rotation** - Logs rotate by date automatically; no size-based rotation configured

5. **Environment-aware thresholds** - Production uses restrictive logging (level 4+) to prevent log file bloat; development uses verbose logging (level 9/all)

6. **No application code currently uses logging** - Grep search found zero `log_message()` calls in `app/` directory controllers, models, or helpers. Logging is primarily used internally by the framework for exceptions and system events.