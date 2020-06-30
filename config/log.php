<?php
/**
 * 日志分为用户日志和系统日志(系统日志和错误日志)，
 */
return array(
    'log_enable' => env('LOG_ENABLE', 0),
    'channel' => env('LOG_CHANNEL', ''),   //频道名 一般定义为系统名    'driver'=>
    'system_driver' => env('LOG_DRIVER', ''), //@log注解或手动记录应用的日志
    'error_driver' => env('LOG_DRIVER_ERROR', ''), //系统捕获的error日志

    'file' => array('path' => env('FILE_LOG_PATH', '')),
    //directory为日志生成在path目录下， general为day则按天 hour按时 month按月 minute按分，prefix为日志文件后缀默认为log
    'directory' => array(
        'path' => env('DIRECTORY_LOG_PATH', ''),
        'prefix' => env('DIRECTORY_LOG_PREFIX', ''),
        'general' => env('DIRECTORY_LOG_GENERAL', '')
    ),
    //如果要用户日志，则一定要配置这个
    'mongodb' => array(
        'host' => env('MONGODB_LOG_HOST', ''),
        'port' => env('MONGODB_LOG_PORT', ''),
        'database' => env('MONGODB_LOG_DATABASE', ''),
        'collection' => env('MONGODB_LOG_COLLECTION', ''),
        'username' => env('MONGODB_LOG_USERNAME', ''),
        'password' => env('MONGODB_LOG_PASSWORD', ''),
    ),
    'redis' =>
        array(
            'host' => env('REDIS_LOG_HOST', ''),
            'port' => env('REDIS_LOG_PORT', ''),
            'password' => env('REDIS_LOG_PASSWORD', ''),
            'key' => env('REDIS_LOG_KEY', ''),
        ),
    //要用graylog,则要引入:graylog2/gelf-php.
    //这个ip和port请在graylog中的 System/inputs->inputs 新建一个gelf udp就OK了，记得端口配置在下面
    'graylog' => array('host' => env('GRAYLOG_LOG_HOST', ''), 'port' => env('GRAYLOG_LOG_PORT', '')),
    //下面的type为任意值
    'browser' => array('type' => 'browser'),
);