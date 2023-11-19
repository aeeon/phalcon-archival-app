<?php

return [
    'base_path' => '',
    //'base_path' => 'http://localhost/yona-cms/web/',
    'database' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => '',
        'charset' => 'utf8',
    ],
    'mail' => [
        'host' => '',
        'username' => '',
        'password' => '',
        'security' => 'tls',
        'port' => 587,
        'charset' => 'UTF-8',
        'email' => '',
        'name' => '',
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
