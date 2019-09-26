<?php

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
];
