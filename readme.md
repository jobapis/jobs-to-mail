# [![JobApis.com](https://i.imgur.com/9VOAkrZ.png)](https://www.jobapis.com) JobsToMail
#### Your personal job-search assistant

[![Latest Version](https://img.shields.io/github/release/jobapis/jobs-to-mail.svg?style=flat-square)](https://github.com/jobapis/jobs-to-mail/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](license.md)
[![Build Status](https://img.shields.io/travis/jobapis/jobs-to-mail/master.svg?style=flat-square&1)](https://travis-ci.org/jobapis/jobs-to-mail)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jobapis/jobs-to-mail.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-to-mail/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobapis/jobs-to-mail.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-to-mail)
[![Total Downloads](https://img.shields.io/packagist/dt/jobapis/jobs-to-mail.svg?style=flat-square)](https://packagist.org/packages/jobapis/jobs-to-mail)

## About

JobsToMail is an open source web application that allows users to sign up to receive emails with jobs from one of several job boards supported by the [JobApis](https://www.jobapis.com/) project. Users can sign up to receive jobs for free at [jobs-to-mail.herokuapp.com](https://jobs-to-mail.herokuapp.com/) or use the setup instructions below to run the application on their own server.

This application is built on [Laravel 5.5](http://laravel.com/) using the [Jobs Multi](https://github.com/jobapis/jobs-multi) and [Jobs Common](https://github.com/jobapis/jobs-common) packages. The frontend uses [Bootstrap v4](http://v4-alpha.getbootstrap.com/) and [Gulp](http://gulpjs.com/).

### Mission

[JobApis](https://www.jobapis.com) makes job board and company data more accessible through open source software. To learn more, visit [JobApis.com](https://www.jobapis.com), or contact us at [admin@jobapis.com](mailto:admin@jobapis.com).

## Setup

### Requirements
This application is only designed to work with PHP 7.0+ and Postgres 9.5+. Some backwards compatibility may be possible, but is not officially supported at this time.

Installation requires the following:

- [PHP 7.1+](http://php.net/releases/7_1_0.php)
- [Postgresql 9.5](https://www.postgresql.org/)
- [Composer](https://getcomposer.org/)
- [Node 6.0+](https://nodejs.org/en/blog/release/v6.0.0/)
- [NPM](https://www.npmjs.com/)
- [Gulp](https://github.com/gulpjs/gulp-cli)
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

### Docker installation
After you've got Docker installed and running:

1. Install composer dependencies: `docker run --rm -v $(pwd):/app composer:latest install`

2. Copy `.env.example` to `.env` and customize it with your environmental variables.

3. Run `docker-compose build` and then `docker-compose up -d` to get the services running.

4. Run `npm install && node node_modules/.bin/gulp` to build the frontend.

5. Run migrations: `docker exec jobstomail_web_1 php artisan migrate`.

6. Run the collect and email command: `docker exec jobstomail_web_1 php artisan jobs:email`.

You can run tests with `docker exec jobstomail_web_1 vendor/bin/phpunit`.

### Heroku installation

1. Use the one-click Deploy to Heroku button: [![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

2. After it's deployed, you should be able to visit your app and see the home page.

3. Set an application key by running `heroku run "php artisan key:generate --show" --app=j2m` and adding the key that is displayed to your app's config variables.

4. Add a job in Heroku Scheduler to run `php artisan jobs:email` every night. This will ensure that users receive their emails.

### Server installation

#### Additional Requirements
- A server running [Linux Ubuntu 16.04+](http://releases.ubuntu.com/16.04/)
- [PHP-FPM](https://php-fpm.org/)
- [NGINX](https://www.nginx.com/resources/wiki/)

1. Use composer to [create a new project](https://getcomposer.org/doc/03-cli.md#create-project):

```
composer create-project jobapis/jobs-to-mail
```

2. Copy `.env.example` to `.env` and customize it with your environmental variables.

3. Run `npm install && gulp` to build the frontend.

4. Point NGINX to serve to the `/public` directory. Your NGINX config block should look something like this:

```conf
server {
    listen       80;
    server_name  yourdomain.com;
    
    root   /home/user/jobs-to-mail/public;
    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}
```

5. Ensure that PHP-FPM is running, and ensure that your site is running at your domain.

6. Create a [cron job](https://www.cyberciti.biz/faq/how-do-i-add-jobs-to-cron-under-linux-or-unix-oses/) to run the job collection and notification process nightly: `php artisan jobs:email`.

## Command Line
After users sign up for a job search, the only thing needed to collect jobs and send them emails is the following command:

```
php artisan jobs:email
```

This command will loop through each user, collect jobs based on their search criteria, and then email them when their list has been compiled.

Because this job search can take a long time, it is best to use a worker and run the job in the background (via cron job). Instructions for setting this up in Heroku are above, but if you have trouble, you can post a question to the Issues tab in the Github repository.

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
If you're doing local development, you may find it handy to seed the database with some test data. Using [Laravel's seed commands you can do just that](https://laravel.com/docs/5.5/seeding):

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

Contributions are welcomed and encouraged! Please see [JobApis' contribution guidelines](https://www.jobapis.com/contributing/) for details, or create an issue in Github if you have any questions.

## Legal

### Disclaimer

This package is not affiliated with or supported by any job boards and we are not responsible for any use or misuse of this software.

### License

This package uses the Apache 2.0 license. Please see the [License File](https://www.jobapis.com/license/) for more information.

### Copyright

Copyright 2016, [Karl L. Hughes](https://www.github.com/karllhughes).
