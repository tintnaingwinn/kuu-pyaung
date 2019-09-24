# Convert files from zawgyi to unicode for Laravel apps

:warning: **This package is under development and is not suitable for production use.** :warning:

## Requirements

#### version-1.x

- [PHP >= 5.6.4](http://php.net/)
- [Laravel 5.2|5.3|5.4](https://github.com/laravel/framework)

#### version-2.x

- [PHP >= 7.0](http://php.net/)
- [Laravel 5.5|5.6|5.7|5.8|6.x](https://github.com/laravel/framework)

## Laravel Version Compatibility

| Laravel | Package | PHP     |
|---------|---------|---------|
| 5.2.x   | 1.x     | >=5.6.4 |
| 5.3.x   | 1.x     | >=5.6.4 |
| 5.4.x   | 1.x     | >=5.6.4 |
| 5.5.x   | 2.x     | >=7.0.0 |
| 5.6.x   | 2.x     | >=7.1.3 |
| 5.7.x   | 2.x     | >=7.1.3 |
| 5.8.x   | 2.x     | >=7.1.3 |
| 6.x     | 2.x     | >=7.2.0 |
 
## Installation and usage

``` bash
composer require tintnaingwin/kuu-pyaung
```

You can publish the config-file with:

``` bash
php artisan vendor:publish --provider="Tintnaingwin\KuuPyaung\KuuPyaungServiceProvider"
```

You can convert your app by running:

``` bash
php artisan kuupyaung:run
```

## Todo

- Convert database (high priority on mysql)
- Backup database

## Testing

Run the tests with:

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email amigo.k8@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
