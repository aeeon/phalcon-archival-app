<?php

return [
    'base_path' => 'http://jakprawnie.local/',
    //'base_path' => 'http://localhost/yona-cms/web/',
    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'jakprawnie',
        'charset' => 'utf8',
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
    'memcache' => [
        'host' => 'localhost',
        'port' => 11211,
    ],
    'cache' => 'file',
    //'cache'     => 'memcache',
];
