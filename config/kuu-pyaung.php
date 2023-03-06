<?php

return [

    /*
     * These resource directories only will convert.
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
     * The value of some columns may be filenames, or you don't want to convert.
     * Eg - 'table_name' => [ 'exclude_column', 'exclude_column' ]
     */
    /*
    'exclude_table_columns' => [
        'users' => [ 'profile_pic', 'file_path' ],
        'orders' => [ 'invoice_path' ]
    ]
    */

];
