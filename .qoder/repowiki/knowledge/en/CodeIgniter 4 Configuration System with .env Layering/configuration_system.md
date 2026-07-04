## Overview

This application uses **CodeIgniter 4's built-in configuration system**, which employs a layered approach combining PHP config classes, environment variables via `.env` files, and optional boot-mode overrides.

## Architecture

### Three-Layer Configuration Loading

1. **`.env` file** (root level) — Environment-specific values loaded first into `$_ENV`, `$_SERVER`, and `getenv()`
2. **PHP Config Classes** (`app/Config/*.php`) — Default values defined as public properties; overridden by matching env vars
3. **Boot-mode overrides** (`app/Config/Boot/{development|production|testing}.php`) — Optional per-environment bootstrap scripts

### Loading Sequence (from `system/Boot.php`)

The bootstrap process follows this order:
1. Define path constants (`APPPATH`, `ROOTPATH`, `SYSTEMPATH`, `WRITEPATH`, `TESTPATH`)
2. Load constants from `app/Config/Constants.php`
3. Parse `.env` file via `CodeIgniter\Config\DotEnv`
4. Define `ENVIRONMENT` constant from `CI_ENVIRONMENT` env var (defaults to `'production'`)
5. Load environment-specific bootstrap: `app/Config/Boot/{ENVIRONMENT}.php`
6. Initialize autoloader with `Autoload` and `Modules` configs
7. Config classes instantiated lazily; each extends `BaseConfig` which auto-populates properties from env vars

## Key Files

| File | Purpose |
|------|---------|
| `.env` | Root-level environment variables (database credentials, base URL, session/security settings) |
| `app/Config/App.php` | Core app settings: baseURL, indexPage, timezone, locale, CSP |
| `app/Config/Database.php` | Database connection groups (`default`, `tests`) with driver, credentials, charset |
| `app/Config/Autoload.php` | PSR-4 namespace mappings, classmap, helper loading |
| `app/Config/Feature.php` | Feature flags for backward-compatibility breaking changes |
| `app/Config/Encryption.php` | Encryption key, driver (OpenSSL/Sodium), cipher settings |
| `system/Config/BaseConfig.php` | Base class all config classes extend; handles env var injection via reflection |
| `system/Config/DotEnv.php` | Parses `.env` file, resolves nested variables (`${VAR}`), populates superglobals |
| `system/Boot.php` | Orchestrates the entire bootstrap sequence |
| `public/index.php` | Web entry point; calls `Boot::bootWeb()` |

## Conventions

### Env Var Naming Convention

`BaseConfig::getEnvValue()` checks multiple patterns for each property:
- `{shortPrefix}.{property}` — e.g., `app.baseURL`
- `{shortPrefix}_{PROPERTY}` — e.g., `app_BASE_URL`
- `{Full\Namespace\Class}.{property}` — e.g., `Config\App.baseURL`
- `{Full\Namespace\Class}_{PROPERTY}` — e.g., `Config\App_BASE_URL`

Checks `$_ENV`, `$_SERVER`, then `getenv()` in that order. Array properties are handled recursively with dot notation (e.g., `database.default.hostname`).

### Type Coercion

- String `'true'` / `'false'` → boolean
- Integer/float properties are cast accordingly
- Values are trimmed of surrounding quotes
- Encryption keys support `hex2bin:` and `base64:` prefixes

### Config Class Structure

All config classes:
- Reside in `app/Config/` namespace `Config`
- Extend `CodeIgniter\Config\BaseConfig` (except `Autoload` which extends `AutoloadConfig`)
- Define defaults as **public typed properties**
- Are instantiated as singletons via the service container

### Environment-Specific Boot Files

Optional files at `app/Config/Boot/{development,production,testing}.php` can override error reporting, debug settings, etc. The current repo has no custom boot files, relying on framework defaults.

### Feature Flags

`app/Config/Feature.php` controls backward-compatibility toggles:
- `$autoRoutesImproved = true` — Uses improved auto-routing
- `$oldFilterOrder = false` — Uses new filter execution order
- `$limitZeroAsAll = true` — `limit(0)` returns all records (legacy behavior)

## Rules for Developers

1. **Never commit sensitive values** — Database passwords, encryption keys, API secrets belong in `.env` (which should be gitignored). Use `app/Config/*.php` only for non-sensitive defaults.

2. **Override via `.env`, not config files** — To change settings per environment, add entries to `.env` using the dotted naming convention (e.g., `database.default.hostname = production-db.example.com`). Do not edit config class defaults directly.

3. **Use correct env var prefixes** — For `app/Config/App.php`, prefix with `app.`. For `app/Config/Database.php`, use `database.`. Match the lowercase class name.

4. **Array config via dot notation** — Nested array values use dots: `database.default.DBDriver = MySQLi` maps to `$default['DBDriver']` in `Database.php`.

5. **Test isolation** — `Database.php` automatically switches to the `tests` group when `ENVIRONMENT === 'testing'`, using an in-memory SQLite database to avoid affecting production data.

6. **Encryption key format** — When setting `encryption.key` in `.env`, use `hex2bin:` or `base64:` prefix for binary-safe key storage.

7. **Config cache** — If `Config\Optimize::$configCacheEnabled` is true, config values are cached after first load. Clear cache when modifying config in production.
