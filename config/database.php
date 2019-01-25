<?php
return [
    'default' => 'mongodb',
    'connections' => [
        'mongodb' => [
            'driver' => 'mongodb',
            // 'host' => env('DB_HOST', 'lumen_mongo'),
            'database' => env('DB_MONGO_DATABASE', 'lumenblog'),
            'dsn' => env('DB_MONGO_DSN', 'mongodb://mongosrv:27017'),
            // 'port' => env('DB_PORT', 27017),
            // 'database' => env('DB_DATABASE'),
            // 'username' => env('DB_USERNAME'),
            // 'password' => env('DB_PASSWORD'),
            'options' => [
                'database' => 'admin' // sets the authentication database required by mongo 3
            ]
        ],
    ],
    'migrations' => 'migrations',
];