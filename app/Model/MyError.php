<?php
declare(strict_types=1);

namespace app\Model;

use DcrPHP\Config\Config;
use DcrPHP\Log\SystemLogger;

/**
 * 本类用来处理额外的错误，比如把错误发往日志中心。
 * Class MyError
 */
class MyError extends \Whoops\Handler\Handler
{

    public function handle()
    {
        // TODO: Implement handle() method.
        //系统日志

        $clsConfig = new Config(CONFIG_DIR .DS. 'log.php');
        $clsConfig->setDriver('php');
        $clsConfig->init();
        $logHandler = $clsConfig->get('log.error_driver');

        $clsSystemLogger = new SystemLogger(CONFIG_DIR . DS . 'log.php'); //配置文件
        $clsSystemLogger->addHandler($logHandler);
        $clsSystemLogger->setLogInfo(
            array(
                'ack' => 0, //1或0 这是成功还是失败
                'level' => 'critical', //warning info debug notice critical emergency
                'add_time' => date('Y-m-d H:i:s'),
                'message' => $this->getException()->getMessage(),
                'source' => 'dcrphp-error',
                'line'=> $this->getException()->getLine(),
                'file'=> $this->getException()->getFile(),
            )
        );
        $clsSystemLogger->critical();
    }
}
