<?php
return [
    'default' => 'mongodb',
    'connections' => [
        'mongodb' => [
            /*
            * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
            * ------------------------------
            * Uncomment this below
            * if you want to use with Docker
            */
            // 'database' => env('DB_MONGO_DATABASE', 'lumenblog'),
            // 'dsn' => env('DB_MONGO_DSN', 'mongodb://mongosrv:27017'),

            'driver' => 'mongodb',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'options' => [
                'database' => 'admin' // sets the authentication database required by mongo 3
            ]
        ],
    ],
    'migrations' => 'migrations',
];