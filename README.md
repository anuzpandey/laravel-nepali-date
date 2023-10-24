# A Laravel Package to convert English Date (A.D.) to Nepali Date (B.S.) and vice-versa.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/anuzpandey/laravel-nepali-date.svg?style=flat-square)](https://packagist.org/packages/anuzpandey/laravel-nepali-date)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/anuzpandey/laravel-nepali-date/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/anuzpandey/laravel-nepali-date/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/anuzpandey/laravel-nepali-date/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/anuzpandey/laravel-nepali-date/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
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

LaravelNepaliDate::from($engDate)->toFormattedNepaliDate();
// Result: १० वैशाख २०५३, सोमबार


$nepDate = '2053-01-10';
LaravelNepaliDate::from($nepDate)->toEnglishDate();
// Result: 1996-04-22

LaravelNepaliDate::from($nepDate)->toFormattedEnglishDate();
// Results: 22 April 1996, Monday

// Other methods
LaravelNepaliDate::from($engDate)->toNepaliDateArray()->toArray();
LaravelNepaliDate::from($engDate)->toEnglishDateArray()->toArray();
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
