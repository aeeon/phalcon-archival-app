<?php

return [
    'base_path' => 'http://jakprawnie.local/',
    //'base_path' => 'http://localhost/yona-cms/web/',
    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'kswadmin',
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
    'redis'  => [
        'host' => '127.0.0.1',
        'port' =>  6379,
    ],    
    'memcache' => [
        'host' => '127.0.0.1',
        'port' => 11211,
    ],
   // 'cache' => 'file',
   'cache'     => 'redis',
 //   'cache'=>'memcache',
];