<?php

return [
    'base_path' => '/',
    //'base_path' => 'http://localhost/yona-cms/web/',

    'database'  => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => '',
        'password' => '',
        'dbname'   => '',
        'charset'  => 'utf8',
    ],
    'mail' => [
        'host' => '',
        'username' => '',
        'password' => '',
        'security' => 'ssl',
        'port' => 465,
        'charset' => 'UTF-8',
        'email' => '',
        'name' => '',
    ],
    'memcache'  => [
        'host' => 'localhost',
        'port' => 11211,
    ],

    'cache'     => 'file',
    //'cache'     => 'memcache',
    
];
