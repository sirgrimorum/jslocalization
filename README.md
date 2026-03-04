# JSLocalization

![Latest Version on Packagist](https://img.shields.io/packagist/v/sirgrimorum/jslocalization.svg?style=flat-square)
![PHP Version](https://img.shields.io/packagist/php-v/sirgrimorum/jslocalization.svg?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/sirgrimorum/jslocalization.svg?style=flat-square)
![License](https://img.shields.io/packagist/l/sirgrimorum/jslocalization.svg?style=flat-square)

Expose Laravel translation files and Eloquent models to JavaScript with a single line. Bind PHP i18n arrays to `window` globals so your frontend code shares the same translations and data as your backend — no AJAX calls, no duplication.

## Features

- **Translation binding** — publish any Laravel language file to a JavaScript global variable
- **Model/collection binding** — serialize any Eloquent model, collection, or array to a JavaScript variable
- **Nested JS object creation** — nested groups are created safely without clobbering existing keys
- **Static method support** — call `Auth::user()`, method chains, or static properties directly from the Blade directive
- **Zero configuration required** — works out of the box with sensible defaults

## Requirements

- PHP >= 8.2
- Laravel >= 9.0

## Installation

```bash
composer require sirgrimorum/jslocalization
```

### Publish configuration (optional)

```bash
php artisan vendor:publish --provider="Sirgrimorum\JSLocalization\JSLocalizationServiceProvider" --tag=config
```

Publishes `config/sirgrimorum/jslocalization.php`.

## Configuration

`config/sirgrimorum/jslocalization.php`

```php
return [
    // View that receives the injected <script> tags (used for auto-injection)
    'bind_trans_vars_to_this_view' => 'layouts.app',

    // Default lang group to expose (the array key inside the language file)
    'trans_group' => 'messages',

    // Global JS variable name that holds all translations
    'default_base_var' => 'translations',

    // Path to language files
    'default_lang_path' => '/resources/lang/',
];
```

## Usage

### Bind a translation file to JavaScript

```blade
{{-- Exposes resources/lang/{locale}/messages.php as window.translations.messages --}}
@jslocalization('messages')

{{-- Expose only a specific group within the file --}}
@jslocalization('messages', 'errors')

{{-- Use a custom JS variable name --}}
@jslocalization('messages', 'errors', 'myApp')
```

The directive outputs a `<script>` tag:

```html
<script>
window.translations = window.translations || {};
translations.messages = { "welcome": "Welcome!", "errors": { ... } };
</script>
```

### Use translations in JavaScript

```js
// After @jslocalization('messages')
console.log(translations.messages.welcome);  // "Welcome!"
alert(translations.messages.errors.not_found); // "Not found"
```

### Bind a model to JavaScript

```blade
{{-- Serialize the authenticated user --}}
@jsmodel('Auth::user()')

{{-- Custom variable name --}}
@jsmodel('Auth::user()', 'currentUser')

{{-- Method chains --}}
@jsmodel('Auth::user()->profile()', 'userProfile')

{{-- Static property --}}
@jsmodel('App\Models\Setting::$defaults', 'appDefaults')
```

Output:

```html
<script>
currentUser = {"id":1,"name":"Alice","email":"alice@example.com"};
</script>
```

### Bind any variable from PHP

You can also pass variables directly using the facade:

```php
// In a controller or view composer
$script = JSLocalization::get('messages', 'errors');    // returns <script>...</script>
$script = JSLocalization::put($collection, 'myData');   // serialize a collection
echo $script;
```

## API Reference

### `JSLocalization::get()`

```php
JSLocalization::get(
    string $langfile,       // Language file name (without .php extension)
    string $group   = '',   // Optional key within the file to expose
    string $basevar = ''    // JS global variable (default: config 'default_base_var')
): string
```

Returns a `<script>` tag that assigns the translation array to `window.{basevar}.{langfile}`.

### `JSLocalization::put()`

```php
JSLocalization::put(
    mixed  $model,          // Eloquent model, collection, array, or object
    string $variable = ''   // JS variable name (default: class basename)
): string
```

Returns a `<script>` tag that assigns the JSON-encoded value to a global variable.

### Blade directive — `@jslocalization`

```blade
@jslocalization(string $langfile, string $group = '', string $basevar = '')
```

### Blade directive — `@jsmodel`

```blade
@jsmodel(string $expression, string $variable = '')
```

`$expression` can be:
- A static method call: `'Auth::user()'`
- A method chain: `'Auth::user()->roles()'`
- A static property: `'App\Models\Config::$defaults'`

## License

The MIT License (MIT). See [LICENSE](LICENSE).
