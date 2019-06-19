# Topsite Application

[![Build Status](https://travis-ci.org/1e4/topsite.svg?branch=develop)](https://travis-ci.org/1e4/topsite)

There are many different topsite applications out there, but none that are open source that have a range of features, we aim to address this, so whether it's a PBBG topsite, Minecraft topsite or any other topsite we aim to be to go solution

## Getting Started

First step is the clone the repo

```
git clone git@github.com:1e4/topsite.git
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
yarn
```

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
* [SB Admin 2](https://startbootstrap.com/themes/sb-admin-2/) - Dependency Management

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Ian Milliken** - *Initial work* - [GitHub](https://github.com/1e4)
* **WaveHack** - *Initial work* - [GitHub](https://github.com/WaveHack) [Twitter](https://twitter.com/WaveHack)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
