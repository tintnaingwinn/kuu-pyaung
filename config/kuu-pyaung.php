<?php

return [

    /*
     * These directories only will be convert.
     */
    'include_files' => [
        'views',
        'lang', // lang/my
    ],

    'database' => [
        /*
         * These tables will be excluded from the convert.
         */
        'exclude_tables' => [
            'migrations',
            'telescope_entries',
            'telescope_entries_tags',
            'telescope_monitoring',
        ],

        /*
         * These data types will be include from the convert.
         *
         * Recommend data type is string.
         */
        'include_data_types' => [
            'char',
            'varchar',
            'tinytext',
            'text',
            'mediumtext',
            'longtext',
        ]
    ]
];
