<?php

return [
    'database' => [
        'dbname' => 'test_db',
        'username' => 'root',
        'password' => 'root',
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ],
    ],
    'DEBUG' => true,
    'min_km' => 5,
    'base_cost' => 150
];
