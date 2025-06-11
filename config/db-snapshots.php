<?php
    return [
        /*
         * The name of the disk on which the snapshots are stored.
         */
        'disk'                     => 'snapshots',
        /*
         * The connection to be used to create snapshots. Set this to null
         * to use the default configured in `config/databases.php`
         */
        'default_connection'       => null,
        /*
         * The directory where temporary files will be stored.
         */
        'temporary_directory_path' => storage_path('db-snapshots'),
        /*
         * Create dump files that are gzipped
         */
        'compress'                 => true,
        /*
         * Only these tables will be included in the snapshot. Set to `null` to include all tables.
         *
         * Default: `null`
         */
        'tables'                   => null,
        /*
         * All tables will be included in the snapshot expect this tables. Set to `null` to include all tables.
         *
         * Default: `null`
         */
        'exclude'                  => null,
    ];
