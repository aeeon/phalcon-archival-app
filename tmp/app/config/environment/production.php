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
        'host' => 'smtp.gmail.com',
        'username' => 'niechcesielogowacdochrome@gmail.com',
        'password' => 'nastme4.',
        'security' => 'ssl',
        'port' => 465,
        'charset' => 'UTF-8',
        'email' => 'niechcesielogowacdochrome@gmail.com',
        'name' => 'Jakprawnie',
    ],
    'memcache'  => [
        'host' => 'localhost',
        'port' => 11211,
    ],

    'cache'     => 'file',
    //'cache'     => 'memcache',
    
];