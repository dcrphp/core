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
    /**
     * @throws \Exception
     */
    public static function init()
    {
        $appConfig = config('app');

        if (!$appConfig) {
            $clsConfig = new Config(CONFIG_DIR . DS . 'app.php');
            $clsConfig->setDriver('php');
            $clsConfig->init();
            $appConfig = $clsConfig->get('app');
        }
        if ('php' == $appConfig['error_engine']) {
            return;
        }
        $request = container('request');
        $handler = '\Whoops\Handler\PrettyPageHandler';
        if (in_array(APP::$runningModel, array('api', 'ajax'))) {
            $handler = '\Whoops\Handler\JsonResponseHandler';
        }
        if ('cli' == APP::$runningModel) {
            $handler = '\Whoops\Handler\PlainTextHandler';
        }
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new $handler());

        //配置的error handler
        try {
            $configHandler = $appConfig['error_handler'];
            if ($configHandler) {
                foreach ($configHandler as $handlerClass) {
                    $whoops->pushHandler(new $handlerClass());
                }
            }
        } catch (\Exception $e) {
        }

        $whoops->register();
    }
}
