<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/phinx/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/phinx/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'cedepas_local',
            'user' => 'root',
            'pass' => '123456',
            'port' => '3306',
            'charset' => 'utf8',
        ],

    ],
    'version_order' => 'creation'
];