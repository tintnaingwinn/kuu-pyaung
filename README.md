# Convert resource files and database from zawgyi to unicode for Laravel apps

## Requirements

#### version-1.x

- [PHP >= 5.6.4](http://php.net/)
- [Laravel 5.2|5.3|5.4](https://github.com/laravel/framework)

#### version-2.x

- [PHP >= 7.0](http://php.net/)
- [Laravel 5.5|5.6|5.7](https://github.com/laravel/framework)

#### version-3.x

- [PHP >= 7.2](http://php.net/)
- [Laravel 5.8|6.x](https://github.com/laravel/framework)

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
 
## Installation and usage

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

*Exclude Tables* - Kuu Pyaung converts only `string` data types from database. You can determine which tables will be excluded from the convert.
In addition, if your table does not have `primary key (id or UUID)`, this table will not be converted.  

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
    'exclude_table_columns' => [
        'users' => [ 'profile_pic', 'file_path' ],
        'orders' => [ 'invoice_path' ]
    ]
```


**We highly recommend that you should use maintenance mode when you convert the database tables in production server.**

### Supported databases

- MySQL
- PostgreSQL
- SQLite

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
