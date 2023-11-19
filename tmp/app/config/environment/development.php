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
        'host' => 'mail.jakprawnie.pl',
        'username' => 'kontakt@jakprawnie.pl',
        'password' => 'rW1jqWQo',
        'security' => 'tls',
        'port' => 587,
        'charset' => 'UTF-8',
        'email' => 'kontakt@jakprawnie.pl',
        'name' => 'Jakprawnie',
    ],    
    'memcache' => [
        'host' => 'localhost',
        'port' => 11211,
    ],
    'cache' => 'file',
    //'cache'     => 'memcache',
];
