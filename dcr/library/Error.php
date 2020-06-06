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
        if ($request->isAjax()) {
            $handler = '\Whoops\Handler\JsonResponseHandler';
        }
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new $handler);

        //配置的error handler
        try {
            $clsConfig = new Config(CONFIG_DIR . DS . 'app.php');
            $clsConfig->setDriver('php');
            $clsConfig->init();
            $configHandler = $clsConfig->get('app.error_handler');
            if ($configHandler) {
                foreach ($configHandler as $handlerClass) {
                    $whoops->pushHandler(new $handlerClass);
                }
            }
        } catch (\Exception $e) {
        }

        $whoops->register();
    }
}
