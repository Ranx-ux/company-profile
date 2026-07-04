## Overview
The repository uses **Composer** as its primary dependency management system, adhering to standard PHP/CodeIgniter 4 conventions. The project is structured as a CodeIgniter 4 application that relies on a mix of Composer-managed dependencies and manually vendored framework components.

## Dependency Declaration
Dependencies are declared in the root-level `composer.json` file. The project requires:
- **PHP**: `^8.2`
- **Core Libraries**: 
  - `laminas/laminas-escaper`: ^2.18 (for output escaping)
  - `psr/log`: ^3.0 (for logging interface compliance)
- **Development Dependencies**: Includes testing tools (`phpunit/phpunit`, `fakerphp/faker`), coding standards (`codeigniter/coding-standard`), and debugging utilities (`kint-php/kint`).

## Vendoring Strategy
The project employs a **hybrid vendoring approach**:
1. **Framework Vendoring**: The entire CodeIgniter 4 framework (`system/` directory) is manually copied into the project root rather than being pulled exclusively via Composer. This is evident from the presence of the `system/` directory at the root and the `codeigniter4-framework-v4.7.2...` reference directory.
2. **Third-Party Library Vendoring**: Specific third-party libraries required by the framework core are vendored into `system/ThirdParty/`. This includes:
   - `Laminas\Escaper` (from `laminas/laminas-escaper`)
   - `Kint` (from `kint-php/kint`)
   - `PSR\Log` (from `psr/log`)

This vendoring is managed by the `CodeIgniter\ComposerScripts::postUpdate()` method, which automatically mirrors these dependencies from the `vendor/` directory into `system/ThirdParty/` during Composer install/update events. This allows the framework to function even if the end-user does not use Composer for the framework itself, though Composer is still used for the project's direct dependencies.

## Autoloading
- **PSR-4 Autoloading**: The `app/Config/Autoload.php` file configures the `App` namespace to map to the `app/` directory.
- **Composer Autoloader**: The entry point (`public/index.php`) and CLI tool (`spark`) rely on `vendor/autoload.php` (defined as `COMPOSER_PATH` in `app/Config/Constants.php`).
- **Class Map**: The `composer.json` excludes database migrations from the classmap to prevent conflicts during autoloading.

## Key Files
- `composer.json`: Defines all project dependencies and scripts.
- `app/Config/Autoload.php`: Configures namespace mapping for the application code.
- `system/ComposerScripts.php`: Handles the automatic vendoring of core framework dependencies into `system/ThirdParty/`.
- `system/ThirdParty/`: Contains the manually vendored copies of `laminas-escaper`, `kint`, and `psr-log`.
- `app/Config/Constants.php`: Defines the path to the Composer autoloader.

## Developer Rules
1. **Dependency Installation**: Always use `composer install` or `composer update` to manage dependencies. Do not manually modify files in `system/ThirdParty/` as they are overwritten during updates.
2. **Framework Updates**: Since the `system/` directory is vendored, updating the CodeIgniter framework requires careful merging or replacing the `system/` directory with the new version, followed by running `composer update` to refresh the `system/ThirdParty/` contents.
3. **Namespace Usage**: Use the `App\` namespace for all application-specific classes located in the `app/` directory.
4. **Lockfile Management**: Ensure `composer.lock` is committed to version control to guarantee consistent dependency versions across environments.