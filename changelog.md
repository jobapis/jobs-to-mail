# Changelog
All Notable changes to `jobs-to-mail` will be documented in this file.

## 1.0.0 - WIP

### Added
- New database table/model for Searches.
- Ability for Users to confirm emails once and create multiple Searches.
- `jobs:email` command now uses Search model instead of User model for queries.

### Removed

### Fixed


## 0.4.0 - 2016-10-14

### Added
- Support for [Ziprecruiter](https://github.com/jobapis/jobs-ziprecruiter) job board.
- Automatically run migrations after composer install.
- Logging errors from collections.
- Model factories for database seed operations.
- Command line argument to run collection job for single email.

### Fixed
- Bug in Careerbuilder API via Jobs-Multi upgrade.
- Removing HTML highlighting characters from Juju job results.

## 0.3.0 - 2016-10-06

### Added
- Date posted to email when valid DateTime object is included in result.
- Support for [Juju](https://github.com/jobapis/jobs-juju) job board.
- Improvements to date sorting in email:
  - Setting max age for results
  - Fixing date comparison by ensuring all results use DateTime
  - Setting max results

### Fixed
- Queue worker on Heroku doesn't work with timeout. Adjusting procfile appropriately.
- Command now queues jobs asynchronously.

## 0.2.0 - 2016-09-29

### Added
- Keyword and location parameters to jobs email.
- Heroku and Composer project setup instructions.
- Terms and privacy policy.

### Fixed
- Old references were loading bootstrap 3 instead of 4.

### Security
- Use `random_bytes()` instead of `openssl_random_pseudo_bytes()` for secure token generation.

## 0.1.0 - 2016-09-25

### Added
- Initial pre-release.
- Features:
    - User can enter valid email with keyword and location
    - User can confirm email
    - Job collection and email command line job
    - One-click unsubscribe

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing
