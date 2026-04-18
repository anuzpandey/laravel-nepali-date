# Changelog

All notable changes to `laravel-nepali-date` will be documented in this file.

## Unreleased

- No changes yet.

## 3.1.0 - 2026-02-05

**Features**
- Add artisan date conversion commands

**Fixes**
- fix(lint): with pint

**Docs**
- docs: add artisan commands to readme

## 3.0.0 - 2026-02-05

**Fixes**
- chore: drop laravel 10 support
- fix(ci): update carbon for laravel 10
- fix(ci): update carbon for laravel 11+
- fix(ci): allow pest 3 for laravel 12
- fix(ci): allow collision 8 for laravel 11
- fix(ci): allow larastan for laravel 12

## 2.4.0 - 2026-02-05

**Fixes**
- fix(ci): remove PHP 8.1 from matrix and phpstan step   PHP 8.1 cannot install pestphp/pest ^2.20 (requires PHP 8.2+ via   paratest dependency). The phpstan analyse step fails because phpstan   is not in composer.json require-dev — it will be added by PR #24   along with the CI step. Also updates composer.json php requirement   to ^8.2 to match.
- test(coverage): add comprehensive test suite
- chore(phpstan): add static analysis with larastan
- chore(ci): update workflow for Laravel 10-12 and PHP 8.1-8.4
- refactor(code-quality): remove duplicate data, fix typo, apply formatting

**Docs**
- docs(readme): add Blade directives and array methods documentation

## 2.3.2 - 2025-10-15

**Features**
- Update composer.json

## 2.3.1 - 2025-06-22

**Features**
- feat: update illuminate contracts

## 2.3.0 - 2025-05-02

**Fixes**
- fix(days-in-month): incorrect old month data being used in daysInMonth method

## 2.2.0 - 2025-04-18

**Features**
- feat: add year 91 ~ 99 month counts

**Fixes**
- fix: year 82 and 83 month count

## 2.1.0 - 2024-09-01

**Fixes**
- :hammer: fix: toFormattedNepaliDate to use config values and remove required arguments.
- :hammer: fix: toNepaliDateArray method and fix tests.
- :hammer: fix: toNepaliDateArray method returning static data.

**Docs**
- :memo: update-readme.

## 2.0.0 - 2024-05-12

**Fixes**
- :white_check_mark: test: add tests to check if the new update fixes the issue.
- :recycle: chore: update EnglishDate feature to omit Carbon usage.
- :recycle: chore: fix toNepaliDate feature to omit Carbon usage.
- :recycle: chore: remove carbon instance support from main class.

**Docs**
- :memo: update readme.
- :memo: readme: update readme to deprecate use of Mixin in the package.

## 1.7.1 - 2024-05-12

**Docs**
- :memo: readme: Update the readme with bug notice.

## 1.7.0 - 2024-05-12

**Features**
- :zap: feat: add new daysInMonth and daysInYear methods.
- :zap: feat: add Nepali Date Data static property and Nepali Month Enum Helpers.

**Fixes**
- :white_check_mark: tests: Add daysInMonth and daysInYear tests.
- :recycle: lint: Code Format with Pint.

**Docs**
- :memo: readme: update readme's usage section to showcase getDaysIn[Month|Year] feature.

## 1.6.5 - 2024-05-10

**Fixes**
- :hammer: fix: 2081 Month Days Fix. - Thanks to @novaprime-code for the issue identification. - Fixes #11.

## 1.6.4 - 2024-04-07

**Fixes**
- :hammer: fix: blade directives signature.

## 1.6.3 - 2024-04-07

**Fixes**
- :hammer: fix: blade directives signature.

## 1.6.2 - 2024-04-07

**Fixes**
- :hammer: fix: blade directives signature.

## 1.6.1 - 2024-04-07

**Fixes**
- :hammer: fix: blade directives signature.

## 1.6.0 - 2024-04-07

**Features**
- :zap: feat: add  and  blade directive.

**Fixes**
- :hammer: fix: - update composer json homepage url with new url.

## 1.5.0 - 2024-03-11

**Features**
- :zap: features: Allow Laravel 11.

## 1.4.0 - 2024-02-17

**Features**
- :zap: feature: - adds a feature where conversion method takes in config value if format and locale value arguments are not passed. - format codes to pint confguration.
- :zap: feature: add publishable config file.

**Fixes**
- :hammer: fix: config file name.

**Docs**
- :sparkles: refac: -  cleanup toFormatted methods and update docblock comment on config file
- :hammer: fix-readme - add a command snippet to readme for config publish.
- :memo: doc: Update CONTRIBUTING.md with Pull Request Guidelines
- :memo: update-docblock: Update Helper file docblock comment.

## 1.3.0 - 2023-11-22

**Features**
- done changes as mention
- Worked on helper function
- Working on helper function to convert date

**Docs**
- :memo: doc: update readme. [no ci]

## 1.2.0 - 2023-11-19

**Features**
- :zap: features: add carbon extension feature with mixin.
- :construction: wip: CarbonMixin Init.

**Fixes**
- :hammer: fix: memory exhaustion issue with recursive call.
- :hammer: fix: remove testing for now.

**Docs**
- :memo: doc: update readme.

## 1.1.0 - 2023-11-19

**Features**
- :zap: features: add locale option to toNepaliDate function.
- :zap: features: add format option on toNepaliDate.

**Fixes**
- :zap: features: fix ordinalSuffix to English Date Value in np locale.
- :zap: features: fix ordinalSuffix to English Date Value.
- :zap: features: add ordinalSuffix to English Date Value.
- :zap: features: add format and locale option to english date method. - Refactor to DRY code.
- :hammer: fix: update getEnglishLocaleFormat method to use the same format feature.
- :zap: features: add user specified format.
- :hammer: fix: remove .DS_Store and add to .gitignore.
- :hammer: fix: codestyle with pint | remove config and support for php < 8.1.
- :hammer: fix: getShortDayName with en locale.

**Docs**
- :memo: doc: update readme and test script
- :hammer: fix: remove code style badge from readme.

## 1.0.0 - 2023-10-24

**Features**
- Added support for converting English date to Nepali date
- Added support for converting Nepali date to English date
- Added support for converting English date to Nepali date array
- Added support for converting Nepali date to English date array
- Added support for converting English date to formatted Nepali date
- Added support for converting Nepali date to formatted English date
- Initial release
