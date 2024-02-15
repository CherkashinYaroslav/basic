<?php

return [
    'components' => [
        'languageSwitcher' => [
            'class' => 'app\widgets\languageSwitcher',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('DB_TYPE', 'mysql')
                .':'
                .'host='
                .env('DB_HOST', '127.0.0.1')
                .';'
                .'port='
                .env('DB_PORT', '3306')
                .';'
                .'dbname='
                .env('DB_NAME', 'root'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
    ],
];
