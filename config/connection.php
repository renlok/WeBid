<?php
return [
    'meta' => [
        'entity_path' => [
            __DIR__.'/../src/Entities'
        ],
        'auto_generate_proxies' => true,
        'proxy_dir' =>  __DIR__.'/../cache/proxies',
        'cache' => null,
    ],
    'connection' => [
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'dbname'   => 'test',
        'user'     => 'root',
        'password' => '',
    ]
];