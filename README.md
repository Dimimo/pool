# The Puerto Galera Billiard Competition Laravel 9|10 package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dimimo/pool.svg?style=flat-square)](https://packagist.org/packages/dimimo/pool)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/dimimo/pool/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/dimimo/pool/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/dimimo/pool/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/dimimo/pool/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/dimimo/pool.svg?style=flat-square)](https://packagist.org/packages/dimimo/pool)

This package is for the Puerto Galera Billiard Competition. It handles diffent seasons (called cycles in the package), 
Teams, playersm, venues and, of course, statistics!


## Installation

You can install the package via composer:

```bash
composer require dimimo/pool
```
An Artisan command can install all elements of the package:

```bash
php artisan pool:install
php artisan migrate
```

Or you can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="pool-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="pool-config"
```

This is the contents of the published config file:

```php
return [
    'prefix'     => 'pool',
    'middleware' => ['web'],
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="pool-views"
```

## Usage

```bash
A full stack package that handles all Pool related routes.
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Dimitri Mostrey](https://github.com/Dimimo)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
