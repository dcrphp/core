<?php
/**
 * 日志分为用户日志和系统日志(系统日志和错误日志)，
 */
return array(
    'channel' => 'dcrphp',   //频道名 一般定义为系统名    'driver'=>
    'system_driver' => env('LOG_DRIVER', ''), //@log注解或手动记录应用的日志
    'error_driver' => env('LOG_DRIVER_ERROR', ''), //系统捕获的error日志

    'file' => array('path' => 'storage/log.log'),
    //directory为日志生成在path目录下， general为day则按天 hour按时 month按月 minute按分，prefix为日志文件后缀默认为log
    'directory' => array('path' => 'storage/log', 'prefix' => 'php', 'general' => 'hour'),
    //如果要用户日志，则一定要配置这个
    'mongodb' => array(
        'host' => 'ip',
        'port' => 'port',
        'database' => 'database',
        'collection' => 'collection',
        'username'=> '',
        'password'=> '',
    ),
    'redis' =>
        array(
            'host' => 'host',
            'port' => 'port',
            'password' => 'password',
            'key' => 'log',
        ),
    //要用graylog,则要引入:graylog2/gelf-php.
    //这个ip和port请在graylog中的 System/inputs->inputs 新建一个gelf udp就OK了，记得端口配置在下面
    'graylog' => array('host' => '10.10.30.217', 'port' => '12201'),
    'browser' => array('type' => 'browser'),
);