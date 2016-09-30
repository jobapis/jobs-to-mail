# Changelog
All Notable changes to `jobs-to-mail` will be documented in this file.

## 0.2.0 - 2016-09-29

### Added
- Keyword and location parameters to jobs email.
- Heroku setup instructions.
- Terms and privacy policy.

## Fixed
- Old references were loading bootstrap 3 instead of 4.

## Security
- Use `random_bytes()` instead of `openssl_random_pseudo_bytes()` for secure token generation.

## 0.1.0 - 2016-09-25

### Added
- Initial pre-release.
- Features:
    - User can enter valid email with keyword and location
    - User can confirm email
    - Job collection and email command line job
    - One-click unsubscribe

## Fixed
- Nothing

## Removed
- Nothing

## Security
- Nothing
