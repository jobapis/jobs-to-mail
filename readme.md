# JobsToMail

[![Latest Version](https://img.shields.io/github/release/jobapis/jobs-to-mail.svg?style=flat-square)](https://github.com/jobapis/jobs-to-mail/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](license.md)
[![Build Status](https://img.shields.io/travis/jobapis/jobs-to-mail/master.svg?style=flat-square&1)](https://travis-ci.org/jobapis/jobs-to-mail)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jobapis/jobs-to-mail.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-to-mail/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobapis/jobs-to-mail.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-to-mail)
[![Total Downloads](https://img.shields.io/packagist/dt/jobapis/jobs-to-mail.svg?style=flat-square)](https://packagist.org/packages/jobapis/jobs-to-mail)

JobsToMail is an open source web application that allows users to sign up to receive emails with jobs from one of several job boards supported by the [JobApis](http://www.jobapis.com/) project. Users can sign up to receive jobs for free at [www.jobstomail.com](http://www.jobstomail.com) or use the setup instructions below to run the application on their own server.

This application is built on [Laravel 5.3](http://laravel.com/) using the [Jobs Multi](https://github.com/jobapis/jobs-multi) and [Jobs Common](https://github.com/jobapis/jobs-common) packages. The frontend uses [Bootstrap v4](http://v4-alpha.getbootstrap.com/) and [Gulp](http://gulpjs.com/).

## Setup

### Requirements
This application is only designed to work with PHP 7.0+ and Postgres 9.5+. Some backwards compatibility may be possible, but is not officially supported at this time.

Installation requires the following:

- [PHP 7.0+](http://php.net/releases/7_0_0.php)
- [Postgresql 9.5](https://www.postgresql.org/)
- [Composer](https://getcomposer.org/)
- [Node 6.0+](https://nodejs.org/en/blog/release/v6.0.0/)
- [NPM](https://www.npmjs.com/)
- A web server ([Nginx](https://nginx.org/en/) recommended)

### Local installation
The recommended installation method is [Composer](https://getcomposer.org/).

1. Use composer to [create a new project](https://getcomposer.org/doc/03-cli.md#create-project):

```
composer create-project jobapis/jobs-to-mail
```

2. Copy `.env.example` to `.env` and customize it with your environmental variables.

3. Run `npm install && gulp` to build the frontend.

4. Run the built-in web server to serve the application: `php artisan serve`.

5. Visit the local application at `localhost:8000`.

6. Once at least one user has signed up, you can run the job collection and email command: `php artisan jobs:email`.

### Heroku installation

1. Run `heroku create` to create a new app on Heroku

2. Run `heroku buildpacks:set heroku/php` to declare it as a PHP application

3. Set Laravel encryption key with: `heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)`

4. Add Postgres to Heroku with: `heroku addons:add heroku-postgresql:hobby-dev`

5. Set the appropriate database config with: `heroku config:set DB_CONNECTION="pgsql_heroku"`

6. Push the code to Heroku with: `git push heroku master`

7. Run `heroku run php artisan migrate` to perform database migrations

8. Run the job collection/email job: `heroku run php artisan jobs:email`. This can be run via [Scheduler](https://elements.heroku.com/addons/scheduler) in order to send emails at regular intervals.

9. Run `heroku config:set QUEUE_DRIVER="database"` to queue up jobs and perform them asynchronously. This is optional, but since Heroku limits your process time it's pretty helpful if you want to process more than a couple records.

9. Launch the app on Heroku by running `heroku open`

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

### Server installation
```
Coming soon.
```

## Command Line
After users sign up for a job search, the only thing needed to collect jobs and send them emails is the following command:

```
php artisan jobs:email
```

This command will loop through each user, collect jobs based on their search criteria, and then email them when their list has been compiled.

Because this job search can take a long time, it is best to use a [queueing system](https://laravel.com/docs/5.3/queues) and run the job in the background (via cron job). Instructions for setting this up in Heroku are above, but if you have trouble, you can post a question to the Issues tab in the Github repository.

You can also run this job for only one email address in your system when testing or debugging:

```
php artisan jobs:email --email=karl@jobstomail.com
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
