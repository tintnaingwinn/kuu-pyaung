# Convert files from zawgyi to unicode for Laravel apps

:warning: **This package is under development and is not suitable for production use.** :warning:

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
