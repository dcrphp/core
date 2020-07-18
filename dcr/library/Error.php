<?php

/**
 * Created by junqing124@126.com.
 * User: dcr
 * Date: 2019/9/18
 * Time: 11:50
 */

namespace dcr;

use DcrPHP\Config\Config;

class Error
{
    public static function init()
    {
        $request = container('request');
        $handler = '\Whoops\Handler\PrettyPageHandler';
        if (in_array(APP::$runningModel, array('api', 'ajax'))) {
            $handler = '\Whoops\Handler\JsonResponseHandler';
        }
        if ('cli' == APP::$runningModel) {
            $handler = '\Whoops\Handler\PlainTextHandler';
        }
        $whoops = new \Whoops\Run();

        //配置的error handler
        try {
            $clsConfig = new Config(CONFIG_DIR . DS . 'app.php');
            $clsConfig->setDriver('php');
            $clsConfig->init();
            $configHandler = $clsConfig->get('app.error_handler');
            if ($configHandler) {
                foreach ($configHandler as $handlerClass) {
                    $whoops->pushHandler(new $handlerClass());
                }
            }
        } catch (\Exception $e) {
        }
        $whoops->pushHandler(new $handler());

        $whoops->register();
    }
}
