# Changelog

This changelog records only the two latest **published** releases of `local_massmailenrol`, verified on October 24, 2026. Each entry describes changes between a published Git tag and its immediately preceding published release tag. The October 20 `-core_text` commit occurred after release `1.1.8` and is intentionally excluded.

## [1.1.8] - 2026-10-15

### CI maintenance
- Updated the PostgreSQL CI service image from version 16 to 17.
- Updated the MariaDB CI service image from version 10 to 11.4.
- Adapted the MariaDB container environment to use `MARIADB_ALLOW_EMPTY_ROOT_PASSWORD` and changed its health check to `healthcheck.sh --connect --innodb_initialized`.

### Release metadata
- Updated `version.php` from internal plugin version `2026101200`, release `1.1.7`, to internal version `2026101500`, release `1.1.8`.
- No application logic files changed between the two published tags.

**Full comparison:** [1.1.7...1.1.8](https://github.com/EduardoKrausME/moodle-local_massmailenrol/compare/1.1.7...1.1.8)

## [1.1.7] - 2026-10-12

### Moodle CI compatibility
- Updated the PHP 8.3 test matrix from the Moodle 5.2 stable branch (`MOODLE_502_STABLE`) to the Moodle 5.3 stable branch (`MOODLE_503_STABLE`).

### Release metadata
- Updated `version.php` from internal plugin version `2026100800`, release `1.1.6`, to internal version `2026101200`, release `1.1.7`.
- No application logic files changed between the two published tags.

**Full comparison:** [1.1.6...1.1.7](https://github.com/EduardoKrausME/moodle-local_massmailenrol/compare/1.1.6...1.1.7)
