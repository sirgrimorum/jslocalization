# SirGrimorum's JSLocalization

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Put localization arrays in JavaScript for Laravel 5.6.

## Install

Via Composer

``` bash
$ composer require sirgrimorum/jslocalization
```
Publish Configuration

``` bash
$php artisan vendor:publish --tag=config
```

## Usage

``` html
{!! JSLocalization::get("admin","messages","transmessages") !!}
<script>
    (function() {
        alert(transmensajes.admin.error);
    })();
</script>
```

## Blade directives

``` html
@jslocalization("admin","error_messages","error")
<script>
    (function() {
        alert(error.error_messages.permissions);
    })();
</script>
```

## Security

If you discover any security related issues, please email andres.espinosa@grimorum.com instead of using the issue tracker.

## Credits

- SirGrimorum [link-author]
- Grimorum Ltda. [link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sirgrimorum/jslocalization.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/scrutinizer/build/g/sirgrimorum/jslocalization.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sirgrimorum/jslocalization.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sirgrimorum/jslocalization.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sirgrimorum/jslocalization.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sirgrimorum/jslocalization
[link-travis]: https://scrutinizer-ci.com/g/sirgrimorum/jslocalization/inspections
[link-scrutinizer]: https://scrutinizer-ci.com/g/sirgrimorum/jslocalization/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sirgrimorum/jslocalization
[link-downloads]: https://desarrollo.grimorum.com/andres/jslocalization
[link-author]: https://github.com/sirgrimorum
[link-contributors]: http://grimorum.com
