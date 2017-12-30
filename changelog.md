# Changelog
All Notable changes to `jobs-to-mail` will be documented in this file.

## 1.2.0 - 2017-12-29

### Fixed
- Reference to outdated bootstrap variable.
- Instructions for Docker installation.
- Extra volume in Docker compose file.
- Styling updates for bootstrap 4 beta.

### Added
- NPM `package-lock.json` file.
- Support for Monster RSS feed and Jobs2Careers.
- Source to list of jobs for each day.
- `max_searches` field to each user that allows more searches. 

### Changed
- Switched Jobs Hub advert out for new email to upgrade link.
- Using config `mail.from.address` for admin email universally.
- Upgraded to Laravel 5.5, PHP 7.1.
- Upgraded several dependencies to new major versions.

### Removed
- Dice's API has been [shut down](https://www.jobapis.com/2017/10/28/dice-job-board-api-shut-down/).

## 1.1.0 - 2017-04-18

### Added
- New "notification" page to view all jobs collected on a day for a specific search term.
- Added recruiters to database seeder.
- Indication when job posted by known recruiter.
- Artisan command to delete notifications > 7 days old: `php artisan notifications:delete`.
- Added Docker files, instructions to readme.

### Changed
- Only returning jobs from the past 48 hours to cut down on repeated results.

## 1.0.0 - 2016-12-31

### Added
- User Logins via email/token.
- Ability for Users to confirm emails once and create multiple Searches.
- Storing daily email data in `notifications` DB table.
- Users can download their daily jobs as a CSV.
- New links to email footer to manage job search subscriptions.
- New page to view a user's searches.
- Filtering out recruiter listings:
  - `recruiters` database table, seeder, model.
  - Boolean value for filtering recruiters from results of a search.
  - New filter to remove recruiter listings if preferred.
- New database table/model for Searches.
- `jobs:email` command now uses Search model instead of User model for queries.
- Moved job/collection-related filters into their own folder.
- Added JS dependencies: Jquery, Bootstrap, Tether.
- Support for new job boards.
- Added timezone to .env
- Premium interest page and form.
- Added images of providers on home page.
- Upgraded to [JobsMulti v1.0](https://github.com/jobapis/jobs-multi).
- Support for PHP 7.1.
- One-click Heroku deploy.

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
