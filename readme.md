# Coconut for Laravel 5.0.x through 5.5.x

[![Total Downloads](https://poser.pugx.org/codypchristian/coconut-sdk-php/d/total.svg)](https://packagist.org/packages/codypchristian/coconut-sdk-php)
[![Latest Stable Version](https://poser.pugx.org/codypchristian/coconut-sdk-php/v/stable.svg)](https://packagist.org/packages/codypchristian/coconut-sdk-php)
[![License](https://poser.pugx.org/codypchristian/coconut-sdk-php/license.svg)](https://packagist.org/packages/codypchristian/coconut-sdk-php)

## Installation

First, pull in the package through Composer via the command line:
```js
composer require codypchristian/coconut-sdk-php ~1.0
```

or add the following to your composer.json file and run `composer update`.

```js
"require": {
    "codypchristian/coconut-sdk-php": "~1.0"
}
```

Then include the service provider within (Laravel 5.3 or below) `app/config/app.php`.

```php
'providers' => [
    'CodyPChristian\Coconut\CoconutServiceProvider'
];
```

If using Laravel 5.4, include service provider withing `config/app.php`

```php
'providers' => [
    CodyPChristian\Coconut\CoconutServiceProvider::class
];
```

If you want to use the facade, add this to the bottom of `app/config/app.php`
And, for convenience, add a facade alias to this same file at the bottom:

```php
'aliases' => [
    'Coconut' => 'CodyPChristian\Coconut\Facades\Coconut',
];
```

If you are using Laravel 5.4 or greater, add as follows, add to `config/app.php`

```php
'aliases' => [
    'Coconut' => CodyPChristian\Coconut\Facades\Coconut::class,
];
```
		

Finally, publish the config by running the `php artisan vendor:publish` command


## Usage

Within your controllers or views, you can use




## Configuration

Eedit the `config/coconut.php` file to edit the settings.