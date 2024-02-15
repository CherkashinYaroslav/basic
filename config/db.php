<?php

//TODO вынест в енв
return [
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

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
