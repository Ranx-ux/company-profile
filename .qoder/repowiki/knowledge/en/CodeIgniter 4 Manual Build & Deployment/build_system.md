The project relies on a manual, framework-centric build and deployment strategy typical of traditional PHP applications, specifically CodeIgniter 4. There are no automated build scripts (Makefile, Rake), containerization definitions (Dockerfile), or CI/CD pipeline configurations (GitHub Actions, GitLab CI) present in the repository.

### Build & Compilation
- **No Compilation Step**: As a PHP project, there is no binary compilation. The application runs directly from source code.
- **Dependency Management**: Dependencies are managed via `composer.json`. The project requires PHP >= 8.2 and specific extensions (`intl`, `mbstring`). Key dependencies include `laminas/laminas-escaper` and `psr/log`.
- **Autoloading**: The project uses PSR-4 autoloading configured in `composer.json`, mapping the `CodeIgniter\` namespace to the `system/` directory. The `spark` CLI tool and `public/index.php` entry point rely on Composer's autoloader and the framework's `Boot` class.

### Database Management
- **Manual Schema Import**: Database schema and seed data are managed through a single static SQL file: `db_company.sql`. This file contains `CREATE DATABASE`, `CREATE TABLE`, and `INSERT` statements for initial data (admin user, company profile, services).
- **Migration Files**: While CodeIgniter migrations exist in `app/Database/Migrations/`, the primary deployment instruction in `README.md` directs users to import `db_company.sql` manually via phpMyAdmin, bypassing the migration runner for initial setup.

### Deployment & Execution
- **Web Server**: The application is designed to run on Apache with `mod_rewrite` enabled, as indicated by the `.htaccess` files in `public/` and `app/`. The `README.md` explicitly mentions XAMPP/WAMP/Laragon environments.
- **Entry Points**: 
  - Web: `public/index.php` bootstraps the framework via `Boot::bootWeb()`.
  - CLI: `spark` script bootstraps the framework via `Boot::bootSpark()` for command-line tasks.
- **Configuration**: Environment-specific settings (database credentials, base URL) are managed via a `.env` file, which must be manually edited before deployment.

### Testing
- **Framework Support**: The `composer.json` includes `phpunit/phpunit` and `codeigniter/coding-standard` in `require-dev`, and defines a `test` script (`phpunit`). However, no custom test suites or CI configurations are present in the project root, suggesting testing is either manual or not yet implemented for this specific application module.