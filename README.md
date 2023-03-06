# Convert resources files and database from zawgyi to unicode for Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tintnaingwin/kuu-pyaung.svg)](https://packagist.org/packages/tintnaingwin/kuu-pyaung)
[![Laravel 10.x](https://img.shields.io/badge/Laravel-10.x-red.svg)](http://laravel.com)
[![Laravel 9.x](https://img.shields.io/badge/Laravel-9.x-red.svg)](http://laravel.com)
[![Laravel 8.x](https://img.shields.io/badge/Laravel-8.x-red.svg)](http://laravel.com)

Kuu Pyaung Package converts resources files and databases from zawgyi to unicode.
 
If the context is unicode, don't worry about the conflict context, Kuu Pyaung hasn't converted unicode context to unicode again. 

## Requirements

#### version-1.x

- [PHP >= 5.6.4](http://php.net/)
- [Laravel 5.2|5.3|5.4](https://github.com/laravel/framework)

#### version-2.x

- [PHP >= 7.0](http://php.net/)
- [Laravel 5.5|5.6|5.7](https://github.com/laravel/framework)

#### version-3.x

- [PHP >= 7.2](http://php.net/)
- [Laravel 5.8|6.x|7.x](https://github.com/laravel/framework)

#### version-4.x

- [PHP >= 7.4](http://php.net/)
- [Laravel 8.x](https://github.com/laravel/framework)

#### version-5.x

- [PHP >= 8.0](http://php.net/)
- [Laravel 8.x|9.x|10.x](https://github.com/laravel/framework)

## Laravel Version Compatibility

| Laravel | Package | PHP     |
|---------|---------|---------|
| 5.2.x   | 1.x     | >=5.6.4 |
| 5.3.x   | 1.x     | >=5.6.4 |
| 5.4.x   | 1.x     | >=5.6.4 |
| 5.5.x   | 2.x     | >=7.0.0 |
| 5.6.x   | 2.x     | >=7.1.3 |
| 5.7.x   | 2.x     | >=7.1.3 |
| 5.8.x   | 3.x     | >=7.2.0 |
| 6.x     | 3.x     | >=7.2.0 |
| 7.x     | 3.x     | >=7.2.5 |
| 8.x     | 4.x     | >=7.4   |
| 9.x     | 5.x     | >=8.1   |
| 10.x    | 5.x     | >=8.1   |
 
## Installation and usage

For Laravel 8.x

``` bash
composer require tintnaingwin/kuu-pyaung:"~4.0"
```

For Laravel 5.8|6.x|7.x

``` bash
composer require tintnaingwin/kuu-pyaung:"~3.0"
```

For Laravel 5.5|5.6|5.7

``` bash
composer require tintnaingwin/kuu-pyaung:"~2.0"
```

For Laravel 5.2|5.3|5.4

``` bash
composer require tintnaingwin/kuu-pyaung:"~1.0"
```

For laravel >=5.5 that's all. This package supports Laravel new [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

If you are using Laravel < 5.5, you also need to add the service provider class to your project's `config/app.php` file:

##### Service Provider
```php
Tintnaingwin\KuuPyaung\KuuPyaungServiceProvider::class,
```

You can publish the config-file with:

``` bash
php artisan vendor:publish --provider="Tintnaingwin\KuuPyaung\KuuPyaungServiceProvider"
```
## Artisan commands

You can convert your app by running:

``` bash
php artisan kuupyaung:run
```

If you would like to convert only the files, run:
``` bash
php artisan kuupyaung:run --only-files
```

If you would like to convert only the database, run:
``` bash
php artisan kuupyaung:run --only-database
```

## Configuration

Kuu Pyaung can be configured directly in /config/kuu-pyaung.php.

This is the contents of the published config file:
``` php
return [

    /*
     * These resource directories only will be convert.
     */
    'include_files' => [
        'views',
        'lang', // lang/my
    ],

    /*
     * These database tables will be excluded from the convert.
     */
    'exclude_tables' => [
        'password_resets',
        'migrations',
        'failed_jobs',
        'telescope_entries',
        'telescope_entries_tags',
        'telescope_monitoring',
    ],
    
    /*
     * These database table columns will be excluded from the convert.
     *
     * The value of the some columns may be filenames or you don't want to convert.
     * Eg - 'table_name' => [ 'exclude_column', 'exclude_column' ]
     */
    'exclude_table_columns' => [
        'users' => [ 'profile_pic', 'file_path' ],
        'orders' => [ 'invoice_path' ]
    ]
    
];
```

**Files Convert**

This package convert only folder under the `resource directories`. You can determine which resource files will be convert. 

``` php
    /*
     * These resource directories only will be convert.
     */
    'include_files' => [
        'views',
        'lang', // lang/my
    ],
```

**Database Convert**

*Exclude Tables* - Kuu Pyaung converts only `string` data types from the database. You can determine which tables will be excluded from the convert. In addition,
if your table does not have `primary key (id or UUID)`, this table will not be converted. 

``` php
    /*
     * These database tables will be excluded from the convert.
     */
    'exclude_tables' => [
            'password_resets',
            'migrations',
            'failed_jobs',
            'telescope_entries',
            'telescope_entries_tags',
            'telescope_monitoring',
    ],
```

*Exclude Columns* - If the value of some columns is maybe zawgyi filenames or file paths. you can add these columns in the exclude_table_columns at the config file.  

``` php
    /*
     * These database table columns will be excluded from the convert.
     *
     * The value of the some columns may be filenames that you don't want to convert.
     * Eg - 'table_name' => [ 'exclude_column', 'exclude_column' ]
     */
    /*
    'exclude_table_columns' => [
        'users' => [ 'profile_pic', 'file_path' ],
        'orders' => [ 'invoice_path' ]
    ]
    */
```

**We highly recommend that you should use maintenance mode when you convert the database tables in production server.**

### Supported databases

- MySQL
- PostgreSQL
- SQLite

## Troubleshoot

You can convert with kuu-pyaung in the following situations,

The first thing if you are using the laravel <5.2 <br>
The second thing you don't want to install current project.

- First, create the [new laravel project](https://laravel.com/docs/8.x/installation#installing-laravel)
- Make sure to join the database.
- Make sure to install the [kuu-pyaung](#installation-and-usage)
- After that you can convert with kuu-pyaung

## Testing

Run the tests with:

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
