<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 19:58
 */
//driver:https://www.doctrine-project.org/projects/doctrine-dbal/en/2.10/reference/configuration.html
return array(
    'type' => env('DB_TYPE', ''),
    'pdo_mysql' =>
        array(
            'host' => env('MYSQL_HOST', '127.0.0.1'),
            'port' => env('MYSQL_PORT', 3306),
            'dbname' => env('MYSQL_DATABASE', 'zhanqun'),
            'user' => env('MYSQL_USERNAME', 'root'),
            'password' => env('MYSQL_PASSWORD', 'root'),
            'charset' => env('MYSQL_CHARSET', 'utf8mb4'),
        ),
    'pdo_sqlite' =>
        array(
            'path' => env('SQLITE_PATH', ''),
            'prefix' => '',
        ),
);