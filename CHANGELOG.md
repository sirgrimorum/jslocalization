# Changelog

All notable changes to JSLocalization will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.4] - 2026-03-02

### Fixed
- Resolved Scrutinizer MySQL test database setup issue
- Removed duplicate `type` key in composer.json

## [1.3.3] - 2026-03-01

### Added
- Laravel 12 support
- Minimum PHP version raised to 8.2

## [1.3.2] - 2026-03-01

### Added
- Scrutinizer CI configuration using PHP 8.2 and PHPUnit 10

## [1.3.1] - 2026-02-26

### Added
- Comprehensive test suite using MySQL (orchestra/testbench)
- Improved group handling for translation exposure

### Fixed
- Restored backward compatibility: passing an empty string as `$group` now behaves the same as omitting it (returns the full lang file instead of an empty object)

## [1.3.0] - 2026-02-23

### Changed
- Updated compatibility to PHP ^8.x and Laravel ^9.0|^10.0|^11.0
- Minimum PHP raised from 7.x to 8.x

## [1.2.7] - 2021-01-11

### Fixed
- `str_` helper function compatibility

## [1.2.6] - 2020-03-02

### Fixed
- Class loading issues after Laravel framework update
- Helper function improvements

## [1.2.5] - 2019-08-05

### Fixed
- Model loading error when a model is passed multiple times

## [1.2.4] - 2019-07-25

### Added
- Support for loading multiple models/objects into JavaScript in one call
- `@jsmodel` directive support for collections and arrays

## [1.2.3] - 2018-03-14

### Fixed
- Autoload naming corrections

## [1.2.0] - 2018-03-13

### Changed
- Migrated from Laravel 5.2 to 5.6 compatibility
- Fixed Blade directive to accept additional parameters
- Removed redundant `put` function duplication

---

> Versions prior to 1.2.0 are not documented here.

[Unreleased]: https://github.com/sirgrimorum/jslocalization/compare/1.3.4...HEAD
[1.3.4]: https://github.com/sirgrimorum/jslocalization/compare/1.3.3...1.3.4
[1.3.3]: https://github.com/sirgrimorum/jslocalization/compare/1.3.2...1.3.3
[1.3.2]: https://github.com/sirgrimorum/jslocalization/compare/1.3.1...1.3.2
[1.3.1]: https://github.com/sirgrimorum/jslocalization/compare/1.3.0...1.3.1
[1.3.0]: https://github.com/sirgrimorum/jslocalization/compare/1.2.7...1.3.0
[1.2.7]: https://github.com/sirgrimorum/jslocalization/compare/1.2.6...1.2.7
[1.2.6]: https://github.com/sirgrimorum/jslocalization/compare/1.2.5...1.2.6
[1.2.5]: https://github.com/sirgrimorum/jslocalization/compare/1.2.4...1.2.5
[1.2.4]: https://github.com/sirgrimorum/jslocalization/compare/1.2.3...1.2.4
[1.2.3]: https://github.com/sirgrimorum/jslocalization/releases/tag/1.2.3
