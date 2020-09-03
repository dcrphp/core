<?php
/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/7/28
 * Time: 20:09
 */
return [

    //时区
    'default_timezone' => 'PRC',

    //是不是debug模式
    'debug' => 0, //1是开启 0是关闭

    'error_engine'=>'dcrphp', //dcrphp:dcrphp处理错误，php:php或web服务器处理错误

    //额外的错误处理
    'error_handler' => array(
        \app\Model\MyError::class,
    ),

    //开启模板缓存
    'view_cache' => 0,

    //orm entity目录
    'entity_dir'=> ROOT_APP . DS . 'Model' . DS . 'Entity' . DS,

    //session
    'session_save_handler' => env('SESSION_SAVE_HANDLER', ''), //redis或file
    'session_save_path'=> env('SESSION_SAVE_PATH', ''), //如果是redis则可配置如下:"tcp://127.0.0.1:3309"
    'session_life_time' => env('SESSION_SAVE_LIFT_TIME', 3600),
];
