<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 19:58
 */

return array(
    'type' => env('DB_TYPE', ''),
    'mysql' =>
        array(
            'main' => array(
                'driver' => env('MYSQL_DRIVER', 'mysql'),
                'host' => env('MYSQL_HOST', '127.0.0.1'),
                'port' => env('MYSQL_PORT', 3306),
                'database' => env('MYSQL_DATABASE', 'zhanqun'),
                'username' => env('MYSQL_USERNAME', 'root'),
                'password' => env('MYSQL_PASSWORD', 'root'),
                'charset' => env('MYSQL_CHARSET', 'utf8mb4'),
                'collation' => env('MYSQL_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix' => env('MYSQL_PREFIX', ''),
            ),
        ),
    'sqlite' =>
        array(
            'main' => array(
                'driver' => 'sqlite',
                'database' => '',
                'prefix' => '',
            )
        ),
);