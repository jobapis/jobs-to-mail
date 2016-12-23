# Changelog
All Notable changes to `jobs-to-mail` will be documented in this file.

## 1.0.0 - WIP

### Added
- User Logins via email/token.
- Ability for Users to confirm emails once and create multiple Searches.
- User tiers
  - Limit of 3 searches for "free" users
  - Limit of 10 searches for "premium" users
- Storing daily email data in `notifications` DB table.
- Premium users can download their daily jobs as a CSV.
- New links to email footer to manage job search subscriptions:
  - Unsubscribe from individual search
  - Unsubscribe from all searches
  - View this user's active searches
- New page to view a user's searches
- Filtering out recruiter listings:
  - `recruiters` database table, seeder, model.
  - Boolean value for filtering recruiters from results of a search.
  - New filter in SearchAndNotifyUser job to remove recruiter listings if preferred.
- New database table/model for Searches.
- `jobs:email` command now uses Search model instead of User model for queries.
- Moved job/collection-related filters into their own folder.
- Added JS dependencies: Jquery, Bootstrap, Tether
- Support for new job boards.
- Added timezone to .env
- Premium interest page and form.
- Upgraded to [JobsMulti v1.0](https://github.com/jobapis/jobs-multi).

### Fixed
- Plaintext email job listings were showing up as blank.
- Moved unsubscribe endpoint to `/users/:id/unsubscribe`.
- Removed uuid unsigned constraint from token table migration.

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
