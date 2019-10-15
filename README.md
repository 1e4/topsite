# Topsite Application

[![Build Status](https://travis-ci.org/pbbg/topsite.svg?branch=develop)](https://travis-ci.org/pbbg/topsite) [![Maintainability](https://api.codeclimate.com/v1/badges/8be22f945708dda410b6/maintainability)](https://codeclimate.com/github/pbbg/topsite/maintainability)[![Test Coverage](https://api.codeclimate.com/v1/badges/8be22f945708dda410b6/test_coverage)](https://codeclimate.com/github/pbbg/topsite/test_coverage)![Discord](https://img.shields.io/discord/339678952547287040?style=plastic)

There are many different topsite applications out there, but none that are open source that have a range of features, we aim to address this, so whether it's a PBBG topsite, Minecraft topsite or any other topsite we aim to be to go solution

## Getting Started

First step is the clone the repo

```
git clone git@github.com:pbbg/topsite.git
```

Copying and editing the `.env` is next, user accounts require verification so SMTP is also needed, we recommend [MailGun](mailgun.com).

```
cp .env.example .env
```

Edit the DB_* details, MAIL_* settings

Next run the following

```
composer install
php artisan key:generate
php artisan migrate:fresh --seed
yarn
yarn prod (or yarn watch for development)
```

*`--seed` on migrate is optional if you want to have sample data*

### Prerequisites

What things you need to install the software and how to install them

```
PHP 7.3
MySQL/MariaDB
Yarn or NPM
```

## Running the tests

We use PHPUnit for tests

```
./vendor/bin/phpunit
```

## Built With

* [Laravel](http://laravel.com) - The web framework used
* [SB Admin 2](https://startbootstrap.com/themes/sb-admin-2/) - Front end template for the administration panel

## Contributing

Please read [CONTRIBUTING.md](https://github.com/pbbg/topsites/CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Ian Milliken** - *Initial work* - [GitHub](https://github.com/1e4) [Twitter](https://twitter.com/1e4_)
* **WaveHack** - *Initial work* - [GitHub](https://github.com/WaveHack) [Twitter](https://twitter.com/WaveHack)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
