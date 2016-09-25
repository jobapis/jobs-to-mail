# Jobs to Mail

[![Latest Version](https://img.shields.io/github/release/jobapis/jobs-to-mail.svg?style=flat-square)](https://github.com/jobapis/jobs-to-mail/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](license.md)
[![Build Status](https://img.shields.io/travis/jobapis/jobs-to-mail/master.svg?style=flat-square&1)](https://travis-ci.org/jobapis/jobs-to-mail)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jobapis/jobs-to-mail.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-to-mail/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobapis/jobs-to-mail.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-to-mail)
[![Total Downloads](https://img.shields.io/packagist/dt/jobapis/jobs-to-mail.svg?style=flat-square)](https://packagist.org/packages/jobapis/jobs-to-mail)

Jobs to Mail is a web application that allows users to sign up to receive a daily email when new jobs are found on one of several job boards.

This application is built on [Laravel 5.3](http://laravel.com/) using the [Jobs Multi](https://github.com/jobapis/jobs-multi) and [Jobs Common](https://github.com/jobapis/jobs-common) packages.

_Note: This application is in pre-release and not ready for use. Please contact me if you're interested in contributing._

## Setup Instructions

```
Coming Soon!
```

## Testing
Tests are run using [PHPUnit](https://phpunit.de/). We also employ [Faker](https://github.com/fzaninotto/Faker) to help with producing fake data and [Mockery](http://docs.mockery.io/en/latest/) to mock dependencies in unit tests.

- Run all tests
```
vendor/bin/phpunit
```

Code coverage reports are automatically generated, and can be found in the `/build` directory after running the test suite.

## Seeding data
If you're doing local development, you may find it handy to seed the database with some test data. Using [Laravel's seed commands you can do just that](https://laravel.com/docs/5.3/seeding):

- Truncate and seed the database tables
```
php artisan db:seed
```

- Seed only
```
php artisan db:seed --class=TestingDatabaseSeeder
```

- Truncate only
```
php artisan db:seed --class=DatabaseTruncater
```

_Note: Truncation is permanent, so be careful running this in your production environment._

## Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests on [Github](https://github.com/jobapis/jobs-to-mail).

## Pull Requests

- **[PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)** - The easiest way to apply the conventions is to install [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer).

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask us to pull from your master branch.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please squash them before submitting.

## License

This is open source software, so share away. For more detailed information, see the [license.md](license.md) file.
