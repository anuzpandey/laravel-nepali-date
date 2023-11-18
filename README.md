# A Laravel Package to convert Dates from BS and AD.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/anuzpandey/laravel-nepali-date.svg?style=flat-square)](https://packagist.org/packages/anuzpandey/laravel-nepali-date)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/anuzpandey/laravel-nepali-date/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/anuzpandey/laravel-nepali-date/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/anuzpandey/laravel-nepali-date.svg?style=flat-square)](https://packagist.org/packages/anuzpandey/laravel-nepali-date)

LaravelNepaliDate is a Laravel package that simplifies the conversion of dates between the Gregorian (English) and Nepali (Bikram Sambat) calendars. This package is a handy tool for projects that require handling dates in both English and Nepali formats, such as websites and applications targeting users in Nepal.

## Installation

You can install the package via composer:

```bash
composer require anuzpandey/laravel-nepali-date
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-nepali-date-views"
```

## Usage

```php
$engDate = '1996-04-22';
LaravelNepaliDate::from($engDate)->toNepaliDate();
// Result: 2053-01-10

LaravelNepaliDate::from($engDate)->toNepaliDate(format: 'D, j F Y');
// Result: सोम, १० वैशाख २०५३

// Format Specifiers are supported and listed below
LaravelNepaliDate::from($engDate)->toNepaliDate(format: 'D, j F Y', locale: 'en');
// Result: Mon, 10 Baisakh 2053


$nepDate = '2053-01-10';
LaravelNepaliDate::from($nepDate)->toEnglishDate();
// Result: 1996-04-22

LaravelNepaliDate::from($nepDate)->toEnglishDate(format: 'l, jS F Y');
// Result: Sunday, 22nd April 1996

// Format Specifiers are supported and listed below
LaravelNepaliDate::from($nepDate)->toEnglishDate(format: 'l, j F Y', locale: 'np');
// Result: आइतबार, २२ बैशाख १९९६
```

## Format Specifiers

The following format specifiers are supported for formatting dates:
- `Y` - Year in four digits
- `y` - Year in two digits
- `m` - Month in two digits with leading zero (01-12/०१-१२)
- `n` - Month in one or two digits without leading zero (1-12/१-१२)
- `M` - Month in three letters (Jan-Dec)
- `F` - Month in full name (January-December/बैशाख-चैत्र)
- `d` - Day in two digits with leading zero (01-31/०१-३२)
- `j` - Day in one or two digits without leading zero (1-31/१-३२)
- `D` - Day in three letters (Sun-Sat/आइत-शनि)
- `l` - Day in full name (Sunday-Saturday/आइतबार-शनिबार)
- `S` - Day in two letters (st, nd, rd, th)

## Extending Carbon with NepaliDateMixin
In order to use the `toNepaliDate` and `toEnglishDate` mixin on Carbon instances, you need to register the `NepaliDateMixin` mixin in your Laravel service provider.

You can do so by adding the following code to your `AppServiceProvider`
```php
<?php

use Anuzpandey\LaravelNepaliDate\NepaliDateMixin;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register the NepaliDateMixin
        Carbon::mixin(new NepaliDateMixin());
    }
}
```

Or create your own service provider with `php artisan make:provider MacroableServiceProvider`,
register it in `config/app.php` and add the following code to the `boot` method.
```php
<?php

use Anuzpandey\LaravelNepaliDate\NepaliDateMixin;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class MacroableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register the NepaliDateMixin
        Carbon::mixin(new NepaliDateMixin());
    }
}
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [AnuzPandey](https://github.com/anuzpandey)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
