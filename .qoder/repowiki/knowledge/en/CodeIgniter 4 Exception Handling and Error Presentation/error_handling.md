The repository utilizes the standard **CodeIgniter 4** error handling architecture, relying on a centralized exception handler, environment-based visibility controls, and custom HTML error views.

### 1. Core System & Approach
- **Framework Handler**: The application uses `CodeIgniter\Debug\ExceptionHandler` as the default handler for all uncaught exceptions. This is configured in `app/Config/Exceptions.php`.
- **Centralized Entry Point**: The `system/CodeIgniter.php` core class acts as the primary dispatcher. It wraps the main request lifecycle in `try-catch` blocks to intercept specific framework exceptions like `PageNotFoundException` and `RedirectException`, as well as generic `Throwable` instances.
- **Environment Sensitivity**: Error presentation is strictly tied to the `ENVIRONMENT` constant (defined in `.env`). 
  - In `production`, detailed stack traces and exception messages are suppressed from the output to prevent information leakage.
  - In `development` or `testing`, full debug information including stack traces is rendered via the `error_exception.php` view.

### 2. Key Configuration & Files
- **`app/Config/Exceptions.php`**: The central configuration file for error handling.
  - `$log = true`: Ensures all exceptions are logged via the PSR-3 Logger service.
  - `$ignoreCodes = [404]`: Prevents 404 errors from cluttering the logs by default.
  - `$errorViewPath`: Points to `APPPATH . 'Views/errors'`, where custom error templates reside.
  - `handler()`: Returns the default `ExceptionHandler` instance. Developers can override this to return custom handlers for specific status codes or exception types.
- **`app/Views/errors/html/`**: Contains the user-facing error templates:
  - `error_404.php`: A custom-styled Bootstrap page for "Page Not Found" errors, localized in Indonesian.
  - `error_exception.php`: A generic error page that conditionally displays stack traces based on the environment.

### 3. Architecture & Conventions
- **Exception Propagation**: Controllers and Models generally allow exceptions to bubble up to the core `CodeIgniter::run()` method. For example, if a controller method is not found, `PageNotFoundException` is thrown and caught by the framework, which then triggers the 404 view.
- **Logging Integration**: Exceptions are automatically logged. The configuration allows filtering out specific HTTP status codes (like 404) from logs to reduce noise.
- **Deprecation Handling**: The system is configured to log deprecations (`$logDeprecations = true`) at `WARNING` level rather than throwing exceptions, ensuring backward compatibility while alerting developers to outdated practices.

### 4. Developer Rules & Patterns
- **No Manual Try-Catch in Controllers**: Application controllers (e.g., `Admin/Auth.php`, `BaseController.php`) do not implement local `try-catch` blocks for general error handling. They rely on the framework's global handler.
- **Validation Errors**: Validation failures are handled via redirect-back with flash data (e.g., `->with('error', '...')`) rather than throwing exceptions, keeping the flow user-friendly for form submissions.
- **Custom 404s**: The application uses a custom HTML view for 404 errors instead of the default framework text response, ensuring brand consistency even in error states.
- **Sensitive Data**: The `$sensitiveDataInTrace` array in `Exceptions.php` can be used to hide specific keys from stack traces if needed, though it is currently empty.